<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/styles/main-layout.css">
    <title>Taskalka</title>
</head>
<body>

    <div id="bar">
        <div id="account">
            {if $content.user}
                <span id="login-name">{$content.user->login} ({$content.user->email})</span>
                <a href="/account/logout">logout</a>
            {else}
                <a href="/account/login">login</a> or <a href="/account/register">register</a>
            {/if}
        </div>
    </div>
    {block 'content'}
        no content
    {/block}
</body>
</html>