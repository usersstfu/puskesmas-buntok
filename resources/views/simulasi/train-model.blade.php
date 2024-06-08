<!DOCTYPE html>
<html>
<head>
    <title>Latih Model</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>Train Model</h1>
    <form action="/train-model" method="POST">
        @csrf
        <button type="submit">Train Model</button>
    </form>

    <h1>Predict</h1>
    <form action="/predict" method="POST">
        @csrf
        <label for="nomor">Nomor Antrian:</label>
        <input type="text" name="nomor" id="nomor" required>
        
        <button type="submit">Predict</button>
    </form>
</body>
</html>
