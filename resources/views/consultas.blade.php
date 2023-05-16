@extends('basico')

@section('conteudo')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div id='calendar'></div>

                </div>
                <!-- /.container-fluid -->

                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h4>Edit Appointment</h4>

                                Start time:
                                <br />
                                <input type="text" class="form-control" name="start_time" id="start_time">

                                End time:
                                <br />
                                <input type="text" class="form-control" name="finish_time" id="finish_time">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <input type="button" class="btn btn-primary" id="appointment_update" value="Save">
                            </div>
                        </div>
                    </div>
                </div>                                 

@endsection