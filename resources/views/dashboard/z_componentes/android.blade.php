@extends('layouts.adminlte')

@section('title')
    Android VIEW
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>

                    <p class="card-text">
                        Some quick example text to build on the card title and make up the bulk of the card's
                        content.
                    </p>

                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                </div>
            </div>

            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>

                    <p class="card-text">
                        Some quick example text to build on the card title and make up the bulk of the card's
                        content.
                    </p>
                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                </div>
            </div><!-- /.card -->
        </div>
        <!-- /.col-md-6 -->
        <div class="col-lg-6">

            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">All together</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                            <i class="fas fa-expand"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    The body of the card
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
@endsection

@section('css')
    {{--<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">--}}
@endsection

@section('js')
    {{--<script src="../../dist/js/adminlte.min.js"></script>--}}
@endsection
