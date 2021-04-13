@extends('layouts.app')

@section('title', 'List of News')

@section('content')
    @if (count($news) === 0)
        Seems like there is no news in database. Maybe it's good reason <a href="{{ route('create_news') }}">to write anything</a>?
    @else
        @foreach ($news as $row)
            <article class="news">
			    <header>
			        <a href="{{ url('/news/'.$row->id) }}"><h2>{{ $article->title }}</h2></a>
			    </header>


			    {!! $article->content !!}


			    <footer>
			        <p>
			            Published <time datetime="{{ $row->created_at }}" title="{{ $row->created_at }}">{{ $news->created_ago }}</time>
			        </p>
			    </footer>
			</article>
        @endforeach

        {{ $articles->links() }}
    @endif
@endsection