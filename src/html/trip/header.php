<!DOCTYPE html>
<html lang="jp">
<!-- body-header -->
  <header class="">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <h2 class="navbar-brand mt-2"><?= $title ?></h2>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <!-- Homeに戻る -->
          <li class="nav-item active">
            <a class="nav-link" href="./back.php">Home <span class="sr-only">(current)</span></a>
          </li>

          <!-- 新規登録 -->
          <form action="./" method="get">
            <li class="nav-item">
              <a class="nav-link" href="./new.php">new</a>
            </li>
          </form>

          <!-- ドロップダウン -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?= $user['name'] ?>さん
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="../logout.php">logout</a>
            </div>
          </li>
        </ul>

        <!-- 検索フォーム -->
        <form action="./" method="get" class="form-inline my-2 my-lg-0">
          <input type="search" name="search" id="search" class="form-control mr-sm-2" placeholder="Search" aria-label="Search">
          <input type="submit" value="🔍検索" class="btn btn-outline-primary">
        </form>

      </div>
    </nav>
  </header>
</html>