<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    @if($errors->any())

        @foreach($errors->all() as $error)

        <div style="color:red;">{{ $error }}</div>
        @endforeach
    @endif
    


        <form method="POST" action="{{route('personne.store')}}" enctype="multipart/form-data">
                @csrf

                <input type="text" name="titre">

                <textarea name="description" id="" cols="30" rows="10"></textarea>

                <button type="submit">Créer</button>
        
        </form>

</body>
</html>