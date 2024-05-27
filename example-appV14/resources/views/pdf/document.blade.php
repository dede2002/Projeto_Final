<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Documento</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
    </style>
</head>
<body>
    <h1>{{ $document->name }}</h1>
    @foreach ($document->fields as $field)
        <p>{{ $field['label'] }}: {{ $data[$field['name']] ?? '' }}</p>
    @endforeach
</body>
</html>
