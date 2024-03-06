<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Tratamento;
use App\Models\Pagamento;
use App\Models\Paciente;
use App\Models\Financeiro;
use App\Models\Questionario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mail;
use App\Mail\NotificaConsulta;
use Illuminate\Support\Arr;


class ConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $consultas = Consulta::with(['paciente'])->get();
        $tratamentos = Tratamento::all();
        $pagamentos = Pagamento::all();
        return view('consultas', ['consultas' => $consultas, 'tratamentos' => $tratamentos, 'pagamentos' => $pagamentos]);
    }

    public function dash(Request $req)
    {
        $receita = DB::scalar("select sum(t.valor) as receita from tratamentos t inner join consultas c on t.id = c.tratamento_id where month(c.inicio_consulta) = month(now()) and year(c.inicio_consulta) = year(now()) and c.pagamento = 'realizado'");
        $gastos = DB::scalar("SELECT sum(valor) from (SELECT sum(quantidade) * valor_unidade as valor, gasto_id from `financeiros` where month(data_registro) = month(now()) and year(data_registro) = year(now()) group by gasto_id) as base");
        $consultas_realizadas = DB::scalar("select count(id) as consultas_realizadas from consultas where monthname(inicio_consulta) = monthname(now()) and year(inicio_consulta) = year(now()) and pagamento = 'realizado'");
        $consultas_agendadas = DB::scalar("select count(id) as consultas_agendadas from consultas where date(inicio_consulta) >= date(now()) and pagamento = 'pendente' and deleted_at is null");
        $nao_realizadas = DB::scalar("select count(id) as nao_realizadas from consultas where date(inicio_consulta) < date(now()) and month(inicio_consulta) = month(now()) and year(inicio_consulta) = year(now()) and pagamento = 'pendente' and deleted_at is null");
        $forma_pagamentos = DB::select("select count(p.forma_pagamento) as qtd,p.forma_pagamento from consultas c inner join pagamentos p on p.id = c.pagamento_id where month(c.inicio_consulta) = month(now()) and year(c.inicio_consulta) = year(now()) and c.pagamento = 'realizado'
        group by p.forma_pagamento");
        DB::select("SET lc_time_names = 'pt_BR';");
        $receita_por_mes = DB::select("select sum(t.valor) as total,  substr(date_format(c.inicio_consulta, '%M'), 1, 3) as mes from consultas c join tratamentos t on t.id = c.tratamento_id where c.pagamento = 'realizado' and year(c.inicio_consulta) = year(now()) group by mes
        order by date_format(c.inicio_consulta, '%m')");
        $mes = DB::scalar("select substr(monthname(now()),1, 3)");
        $canais_de_origem = DB::select("SELECT COUNT(p.id) as qtd, c.canal from pacientes p inner JOIN canais_de_origem c on c.id = p.canal_origem_id where p.deleted_at is null GROUP BY canal order by qtd desc");

        if($forma_pagamentos){
            foreach($forma_pagamentos as $pg){
                $pagamentos['qtd'][] = $pg->qtd;
                $pagamentos['forma_pagamento'][] = $pg->forma_pagamento;
            }
            $pie = json_encode($pagamentos);
        }else{
            $pie = '';
        }

        if($receita_por_mes){
            foreach($receita_por_mes as $rm){
                $receita_mes['total'][] = $rm->total;
                $receita_mes['mes'][] = $rm->mes;
            }
            $chart_area = json_encode($receita_mes);
        }else{
            $chart_area = '';
        }

        return view('home', [ 'receita' => $receita, 'consultas_realizadas' => $consultas_realizadas, 'consultas_agendadas' => $consultas_agendadas, 'nao_realizadas' => $nao_realizadas, 'pie' => $pie, 'chart_area' => $chart_area, 'gastos' => $gastos, 'mes' => $mes, 'canais_de_origem' => $canais_de_origem ]);
    }

    /*
    public function graficoPie(){
        $forma_pagamentos = DB::select("select count(p.forma_pagamento) as qtd,p.forma_pagamento from consultas c inner join pagamentos p on p.id = c.pagamento_id where month(c.inicio_consulta) = month(now()) and c.pagamento = 'realizado'
        group by p.forma_pagamento");
        foreach($forma_pagamentos as $pg){
            $pagamentos['qtd'][] = $pg->qtd;
            $pagamentos['forma_pagamento'][] = $pg->forma_pagamento;
        }
        return response()->json($pagamentos);
    }
    */

    public function ajaxUpdate(Request $req)
    {
        $consulta = Consulta::find($req->consulta_id);
        $consulta->update($req->all());

        return response()->json(['consulta' => $consulta, 'paciente' => $consulta->paciente ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $regras = [
            'inicio_consulta' => 'required',
            'fim_consulta' => 'required',
            'tratamento_id' => 'required',
            'pagamento_id' => 'required',
            'pagamento' => 'required',
            'paciente_id' => 'required'
        ];

        $feedback = [
            'required' => 'O campo :attribute deve ser preenchido'
        ];

        $req->validate($regras, $feedback);

        $resultado = Consulta::create($req->all());
        $tratamento = Tratamento::find($req->tratamento_id);
        $valor_tratamento = $tratamento->valor;
        //insere informações na tabela de controle financeiro
        $financeiro = Financeiro::create([
            'data_registro' => $req->inicio_consulta,
            'tratamento_id' => $req->tratamento_id,
            'pagamento_id' => $req->pagamento_id,
            'consulta_id' => $resultado->id,
            'pagamento' => $req->pagamento,
            'valor_tratamento' => $valor_tratamento,
            'quantidade' => 0,
            'valor_unidade' => 0
        ]);

        $msg = $resultado == true ? 'Consulta agendada com sucesso.' : 'Ocorreu algum erro, consulta não agendada.';
        $alert = $resultado == true ? 'success' : 'danger';
        if($resultado){
            $paciente = Paciente::select('email','nome')->where('id', $req->paciente_id)->first();
            $emailData = [
                'id' => $resultado->id,
                'assunto' => '',
                'title' => 'Consulta agendada.',
                'body' => "Olá, $paciente->nome sua consulta foi agendada para o dia ".date("d/m/Y", strtotime($req->inicio_consulta)). " às " .date("H:i", strtotime($req->inicio_consulta)). " horas.",
            ];

            Mail::to($paciente->email)->send(new NotificaConsulta($emailData));
            Log::info("Novo email enviado para $paciente");
            Log::info($emailData['body']);
        }
        return redirect()->route('paciente.show', [$req->paciente_id])->with('msg', $msg)->with('alert', $alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req)
    {
        $id = $req->id;
        $resultado = Consulta::find($id);
        if($resultado->pagamento == 'realizado'){

            $msg = 'Consultas com pagamento realizado não podem ser alteradas.';
            $alert = 'warning';
        }
        elseif($resultado->pagamento == 'pendente'){
            //se não teve alteração na data da consulta, não envio e-mail para o cliente, utilizando a variável 'envia'
            $envia = date("Y-m-d H:i:s", strtotime($req->inicio_consulta)) != $resultado->inicio_consulta ? true : false;

            $resultado->update($req->all());
            $tratamento = Tratamento::find($req->tratamento_id);
            $valor_tratamento = $tratamento->valor;
            //atualiza as informações na tabela de controle financeiro
            Financeiro::where('consulta_id', $id)
                ->update([
                    'data_registro' => $req->inicio_consulta,
                    'tratamento_id' => $req->tratamento_id,
                    'pagamento_id' => $req->pagamento_id,
                    'pagamento' => $req->pagamento,
                    'valor_tratamento' => $valor_tratamento
                ]);
            $msg = $resultado == true ? 'Consulta atualizada com sucesso.' : 'Ocorreu algum erro, consulta não atualizada.';
            $alert = $resultado == true ? 'success' : 'danger';
            if($envia){
                $paciente = Paciente::select('email','nome')->where('id', $req->paciente_id)->first();
                $emailData = [
                    'id' => $id,
                    'assunto' => 'Consulta reagendada',
                    'title' => 'Consulta reagendada.',
                    'body' => "Olá, $paciente->nome sua consulta foi reagendada para o dia ".date("d/m/Y", strtotime($req->inicio_consulta)). " às " .date("H:i", strtotime($req->inicio_consulta)). " horas.",
                ];

                Mail::to($paciente->email)->send(new NotificaConsulta($emailData));
                Log::info("Novo email enviado para $paciente");
                Log::info($emailData['body']);
            }
            //se a atualização veio pelo form da tela de consultas/calendário, então volto pra essa rota
            if($req->event_id){
                return redirect()->route('consulta.index')->with('msg', $msg)->with('alert', $alert);
            }
        }
        //caso a atualização tenha vindo pela tela de cadastro do cliente, então volto para essa rota
        return redirect()->route('paciente.show', [$req->paciente_id])->with('msg', $msg)->with('alert', $alert);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req, string $id)
    {
        /**
         * a variável 'consulta' é utilizada para popular a data e horário da consulta cancelada no corpo do e-mail
         * na variável 'deletado' essas informações já não são armazenadas pois retorna sucesso ou insucesso
        */
        $consulta = Consulta::find($id);
        if($consulta->pagamento == 'realizado'){

            $msg = 'Consultas com pagamento realizado não podem ser excluídas.';
            $alert = 'danger';
        }

        elseif($consulta->pagamento == 'pendente'){
            $deletado = Consulta::find($id)->delete();

            $msg = $deletado == true ? 'Consulta cancelada com sucesso.' : 'Ocorreu algum erro, consulta não cancelada.';
            $alert = $deletado == true ? 'success' : 'danger';
            if($deletado){
                $paciente = Paciente::select('email','nome')->where('id', $req->paciente_id)->first();
                $emailData = [
                    'assunto' => 'Consulta cancelada',
                    'title' => 'Consulta cancelada.',
                    'body' => "Olá, $paciente->nome sua consulta para o dia ".date("d/m/Y", strtotime($consulta->inicio_consulta)). " às " .date("H:i", strtotime($consulta->inicio_consulta)). " horas foi cancelada.",
                ];

                Mail::to($paciente->email)->send(new NotificaConsulta($emailData));
                Log::info("Novo email enviado para $paciente");
                Log::info($emailData['body']);
            }
        }
        return redirect()->route('paciente.show', [$req->paciente_id])->with('msg', $msg)->with('alert', $alert);
    }

    //função onde o cliente confirma se deseja cancelar a consulta
    public function cancelaConsultaEmail($id){
        $consulta = Consulta::with(['paciente'])->find(base64_decode($id));
        if ($consulta == null){
            return view('consulta_cancelada');
        }
        return view('cancela_consulta_email', ['consulta' => $consulta]);
    }

    //função que cancela a consulta selecionada pelo cliente
    public function cancelaConsulta(Request $req, string $id)
    {

        $data_nascimento = Paciente::find(base64_decode($req->paciente_id));
        $regras = [
            /**aqui estou verificando se a data de nascimento
             * informada no form de cancelamento de consulta
             * é igual a data grava no banco de dados
             */
            'data_nascimento' => 'date_equals:'.$data_nascimento->dt_nascimento,
        ];

        $feedback = [
            'date_equals' => 'Por favor, verifique a data de nascimento.'
        ];
        //dd($regras);
        //dd($data_nascimento->dt_nascimento);
        $req->validate($regras, $feedback);
        /**
         * a variável 'consulta' é utilizada para popular a data e horário da consulta cancelada no corpo do e-mail
         * na variável 'deletado' essas informações já não são armazenadas pois retorna sucesso ou insucesso
        */
        $consulta = Consulta::find(base64_decode($id));
        $deletado = Consulta::find(base64_decode($id))->delete();

        $msg = $deletado == true ? 'Consulta cancelada com sucesso.' : 'Ocorreu algum erro, consulta não cancelada.';
        $alert = $deletado == true ? 'success' : 'danger';
        if($deletado){
            $paciente = Paciente::select('email','nome')->where('id', base64_decode($req->paciente_id))->first();
            $emailData = [
                'assunto' => 'Consulta cancelada',
                'title' => 'Consulta cancelada.',
                'body' => "Olá, $paciente->nome sua consulta para o dia ".date("d/m/Y", strtotime($consulta->inicio_consulta)). " às " .date("H:i", strtotime($consulta->inicio_consulta)). " horas foi cancelada.",
            ];

            Mail::to($paciente->email)->send(new NotificaConsulta($emailData));
            Log::info("Novo email enviado para $paciente");
            Log::info($emailData['body']);
        }
        return view('cancela_consulta_email', ['msg' => $msg ]);
    }
}
