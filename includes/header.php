<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    
    <a class="navbar-brand collapse navbar-collapse" href="/">Task List</a>
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <div class="nav-link disabled"><?php if ($login) echo 'Привет, '.htmlspecialchars($login); ?></div>
        </li>
    </ul>
    <div>
        <a class="navbar-brand collapse navbar-collapse" href="/login.php">Выйти</a>
    </div>
</nav>