<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mail;
use App\Mail\Aniversario;

class DisparaEmailAniversario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emailaniversario:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispara email na data de aniversário';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $consultas = DB::select('SELECT * from pacientes where date_format(dt_nascimento, "%M %d") = date_format(now(), "%M %d") and deleted_at is null');

        foreach($consultas as $consulta){

            $msg1 ="Querido(a), $consulta->nome, ";
            $msg2 = "Hoje celebramos não apenas mais um ano de vida, mas também a jornada única e valiosa que você percorreu. Que este aniversário seja um lembrete do quanto você é forte e capaz. Que este novo ciclo seja repleto de realizações e descobertas significativas. Estou aqui para apoiá-lo(a) em todas as fases dessa jornada.";
            $emailData = [
                'title' => 'Feliz Aniversário.',
                'body' => "$msg1 "."\r\n\r\n"."  $msg2"
            ];

            Mail::to($consulta->email)->send(new Aniversario($emailData));
            Log::info("Novo email enviado para $consulta->nome");
            Log::info($emailData['body']);
        }

    }
}
