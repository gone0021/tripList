<!DOCTYPE html>
<html lang="jp">
  <!-- body-header -->
  <header class="mb-4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <!-- タイトル -->
      <h2 class="navbar-brand mt-2"><?= $title ?></h2>

      <!-- ハンバーガーメニュー -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- ナビバー -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="navbar-nav navbar-collapse"></div>
        <ul class="navbar-nav mr-auto">
          <!-- Homeに戻る -->
          <li class="nav-item">
            <a class="nav-link" href="../../">Home</a>
          </li>

          <!-- 新規登録 -->
          <li class="nav-item">
            <a class="nav-link" href="../new/">new</a>
          </li>
        </ul>
      </div>
    </nav>

  </header>
</html>