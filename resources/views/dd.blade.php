<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
dd
</body>
</html>
<script>
    const editor = new EditorJS({
        holder: 'editorjs',
        tools: {
            header: {
                class: Header,
                shortcut: 'CTRL+ALT+3',
                config: {
                    placeholder: 'عنوان خود را وارد کنید',
                    levels: [1, 2, 3],
                    defaultLevel: 3
                }
            }
        }
    });
</script>
