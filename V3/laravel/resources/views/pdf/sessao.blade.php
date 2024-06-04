<!DOCTYPE html>
<html>
<head>
    <title>Session PDF</title>
</head>
<body>
    <h1>Informações da Sessão</h1>
    <p><strong>Médico:</strong> {{ $psychologist->name }}</p>
    <p><strong>Cliente:</strong> {{ $client->name }}</p>
    <p><strong>Horário:</strong> {{ $session_date }}</p>
</body>
</html>
