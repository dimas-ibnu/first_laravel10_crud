<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Data Post - SantriKoding.com</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">

                    <div class="card-body">
                        <h4 class="font-weight-bold">DETAIL</h4>
                        <hr>
                        {{-- back button --}}
                        <a href="{{ route('posts.index') }}" class="btn btn-md btn-success mb-3">BACK</a>
                        {{-- Detail Data Post --}}
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">GAMBAR</td>
                                    <td>
                                        <img src="{{ asset('storage/posts/' . $post->image) }}" width="96px" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">JUDUL</td>
                                    <td>{{ $post->title }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">KONTEN</td>
                                    <td>{!! $post->content !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</body>
