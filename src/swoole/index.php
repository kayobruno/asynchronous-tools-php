<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Teste de Socket com Swoole</title>
    </head>

    <body>
        <output></output>
        <input type="text">
    </body>

    <script>
        const ws = new WebSocket('ws://0.0.0.0:9002');
        const input = document.querySelector('input');
        const output = document.querySelector('output');

        ws.addEventListener('open', console.log);
        ws.addEventListener('message', console.log);

        ws.addEventListener('message', message => {
           const data = JSON.parse(message.data);
           if (data.type === 'chat') {
                output.append('Outro: ' + data.text, document.createElement('br'));
           }
        });

        input.addEventListener('keypress', e => {
            if (e.code === 'Enter') {
                const value = input.value;
                output.append('Eu: ' + value, document.createElement('br'));
                ws.send(value);

                input.value = '';
            }
        });
    </script>

</html>
