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

        <p><?php echo e($variation['greeting']); ?></p>

        <p><?php echo e($variation['introduction']); ?></p>

        <p><?php echo e($variation['question_intro']); ?></p>

        <div class="question">
            <p><?php echo e($question->content); ?></p>
        </div>

        <p><?php echo e($variation['justification']); ?></p>

        <p><?php echo e($variation['closing']); ?></p>

        <div class="signature">
            <p>Atentamente,</p>
            <p><strong><?php echo e($senderName); ?></strong></p>
            <div class="organization">
                <p><?php echo e($organization ?? 'Representante de Gremio MYPE'); ?></p>
                <?php if(isset($phone)): ?>
                <p>Teléfono: <?php echo e($phone); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\sendmail\resources\views/emails/mype-consulta.blade.php ENDPATH**/ ?>