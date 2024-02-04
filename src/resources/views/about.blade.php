@extends('web::layouts.grids.4-4-4')

@section('title', 'Seat Discourse')
@section('page_header', 'Seat Discourse')
@section('page_description', 'About')

@section('left')

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">SeAT-Discourse</h3>
    </div>
    <div class="panel-body">
      <div class="box-body">

        <legend>Thank you</legend>

        <p>This is updated fork of <a href="https://github.com/herpaderpaldent/seat-discourse">herpaderpaldent/seat-discourse</a> It is somewhat deprecated and archived since SeAT 4.0.</p>

        <p>This is originally created by <a href="https://evewho.com/pilot/Herpaderp%20Aldent/"> {!! img('characters', 'portrait', 95725047, 64, ['class' => 'img-circle eve-icon small-icon']) !!} Herpaderp Aldent</a></p>

        <p>If you like <code>SeAT-Discourse</code>, i highly appreciate ISK Donations to original creater.</p>

        </div>
    </div>
  </div>

@stop
@section('center')

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">About</h3>
    </div>
    <div class="panel-body">

      <legend>Bugs and issues</legend>

      <p>If you find something is not working as expected, please don't hesitate and submit an <a href="https://github.com/Goemktg/seat-discourse/issues/new">issue on Github</a></p>

    </div>
  </div>

@stop
@section('right')
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><i class="fa fa-rss"></i> Update feed</h3>
    </div>
    <div class="panel-body" style="height: 500px; overflow-y: scroll">
      {!! $changelog !!}
    </div>
    <div class="panel-footer">
      <div class="row">
        <div class="col-md-6">
          Latest version:
          <a href="https://packagist.org/packages/goemktg/seat-discourse">
            <img src="https://poser.pugx.org/goemktg/seat-discourse/v/stable" alt="SeAT Discourse version" />
          </a>
        </div>
      </div>
    </div>
  </div>
@stop
