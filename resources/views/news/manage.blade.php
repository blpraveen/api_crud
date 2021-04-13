@extends('layouts.app')

@if (@$news->title)
    @section('title', 'Edit news &mdash; '.$news->title)
@else
    @section('title', 'Create news')
@endif

@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <form method="post" id="news_create">
        {{ csrf_field() }}
        <div class="row justify-content-center">
        <div class="col-md-6">
        <fieldset>
            <section>
                <label for="title">News title</label>
                <input type="text" maxlength="255" name="title" id="title" value="{{ @$news->title }}" class="form-control" required>

                @if ($errors->has('title'))
                    <p>
                        <strong>Warning:</strong> {{ $errors->first('title') }}
                    </p>
                @endif
            </section>

            <section>
                <label for="content">News Content</label>
                <textarea maxlength="65535" name="content" id="content" rows="5" required class="form-control">{{ @$news->content }}</textarea>

                @if ($errors->has('content'))
                    <p>
                        <strong>Warning:</strong> {{ $errors->first('body') }}
                    </p>
                @endif
            </section>

           

            <section>
                @if (@$news->id)
                    <label>
                        <input type="checkbox" name="remove" id="remove" value="yes"> Remove news
                    </label>

                    @if ($errors->has('remove'))
                        <p>
                            <strong>Warning:</strong> {{ $errors->first('remove') }}
                        </p>
                    @endif
                @endif
            </section>

            <section>
                <input type="hidden" name="id" value="{{ @$news->id }}">

                @if ($errors->has('id'))
                    <p>
                        <strong>Warning:</strong> {{ $errors->first('id') }}
                    </p>
                @endif

                <button type="submit">Submit</button>
            </section>
        </fieldset>
    </div>
</div>
    </form>
    <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
  <script>
    $(document).ready(function () {
       $('#news_create').submit(function (e) {
            e.preventDefault();
            alert('hi');
       })
    });
  </script>
@endsection