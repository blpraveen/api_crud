@extends('layouts.app')

@section('title', $article->title)
@section('description', $article->body_preview)



@section('content')
    <section>
       <article class="news">
                <header>
                    <a href="{{ url('/news/'.$news->id) }}"><h2>{{ $news->title }}</h2></a>
                </header>


                {!! $article->content !!}


                <footer>
                    <p>
                        Published <time datetime="{{ $news->created_at }}" title="{{ $news->created_at }}">{{ $news->created_ago }}</time>
                    </p>
                </footer>
            </article>
    </section>

    <section>
        <h4>Display Comments</h4>
        @foreach($comments as $comment)
        <div class="display-comment">
            <strong>{{ $comment->nick_name }}</strong>
            <p>{{ $comment->content }}</p>
        </div>
    @endforeach
        <hr />
        <h4>Add comment</h4>
        <form method="post" action="{{ route('comments.store'   ) }}">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="body"></textarea>
                <input type="hidden" name="post_id" value="{{ $news->id }}" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Add Comment" />
            </div>
        </form>
    </section>
@endsection