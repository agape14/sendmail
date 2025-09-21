<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Proceso Electoral MYPE</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.5;
            color: #333;
            max-width: 700px;
            margin: 0 auto;
            padding: 30px;
            background-color: #ffffff;
        }
        .content {
            margin: 20px 0;
        }
        .question {
            margin: 25px 0;
            font-weight: normal;
        }
        .signature {
            margin-top: 40px;
            margin-bottom: 20px;
        }
        .organization {
            margin-top: 15px;
            font-style: italic;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="content">
        <p><strong>Para:</strong> Programa Nacional Compras a MYPErú<br>
        <strong>Asunto:</strong> Consultas sobre el proceso electoral de representantes de MYPE</p>

        <p>{{ $variation['greeting'] }}</p>

        <p>{{ $variation['introduction'] }}</p>

        <p>{{ $variation['question_intro'] }}</p>

        <div class="question">
            <p>{{ $question->content }}</p>
        </div>

        <p>{{ $variation['justification'] }}</p>

        <p>{{ $variation['closing'] }}</p>

        <div class="signature">
            <p>Atentamente,</p>
            <p><strong>{{ $senderName }}</strong></p>
            <div class="organization">
                <p>{{ $organization ?? 'Representante de Gremio MYPE' }}</p>
                @if(isset($phone))
                <p>Teléfono: {{ $phone }}</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
