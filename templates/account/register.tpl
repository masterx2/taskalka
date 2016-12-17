{block 'content'}

    <h1>Регистрация</h1>

    {if $content.error}
        <div class="error">{$content.error}</div>
    {/if}

    <form action="" method="post">
        <label for="login">Login</label>
        <input type="text" name="login" id="login">
        <br>
        <label for="email">E-mail</label>
        <input type="text" name="email" id="email">
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <br>
        <input type="submit" value="Login">
    </form>

    <pre>{$content|var_dump}</pre>

{/block}