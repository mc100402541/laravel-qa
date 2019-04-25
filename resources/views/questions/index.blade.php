@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">All Questions</div>

                <div class="card-body">
                    @foreach ($questions as $question)
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mt-0">{{ $question->title }}</h3>
                                <p>{{ str_limit($question->body, 250) }}</p>

                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <div class="mx-auto">
                    {{ $questions->links() }}
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
