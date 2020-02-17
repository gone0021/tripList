
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="x0XPxUxA7tSYVdem2KJzMuAy1kyU6qTjO5oI1PRJ">

    <title>タスク一覧</title>

    <!-- Styles -->
    <link rel="stylesheet" href="http://192.168.1.50:8081/css/app.css">
    <link rel="stylesheet" href="http://192.168.1.50:8081/css/main.css">
<link rel="stylesheet" href="http://192.168.1.50:8081/js/jquery-ui-1.12.1/jquery-ui.min.css">
<link rel="stylesheet" href="http://192.168.1.50:8081/js/jquery-ui-1.12.1/jquery-ui.structure.min.css">
<link rel="stylesheet" href="http://192.168.1.50:8081/js/jquery-ui-1.12.1/jquery-ui.theme.min.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="http://192.168.1.50:8081/task">
                        タスク一覧                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                                                    <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    nakajima <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="/task" onclick="location.href='/task';">タスク一覧</a>
                                    </li>
                                    <li>
                                            <a href="/task/add" onclick="location.href='/task/add';">新規追加</a>
                                    </li>
                                    <li>
                                        <a href="http://192.168.1.50:8081/logout"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            ログアウト
                                        </a>

                                        <form id="logout-form" action="http://192.168.1.50:8081/logout" method="POST" style="display: none;">
                                            <input type="hidden" name="_token" value="x0XPxUxA7tSYVdem2KJzMuAy1kyU6qTjO5oI1PRJ">
                                        </form>
                                    </li>
                                </ul>
                            </li>
                                            </ul>
                </div>
            </div>
        </nav>
    </div>

    <main>
            <div class="search">
        <form action="/task/search" method="get">
            <input type="hidden" name="_token" value="x0XPxUxA7tSYVdem2KJzMuAy1kyU6qTjO5oI1PRJ">
            <input type="text" name="search" class="form-control" value="">
            <input type="submit" value="🔍" class="btn">
        </form>
    </div>
    <table class="list">
        <tr>
            <th>項目名</th>
            <th>担当者</th>
            <th>登録日</th>
            <th>期限日</th>
            <th>完了日</th>
            <th>操作</th>
        </tr>
                                <tr class="completed">
                <td>魏から使者が来るかも？</td>
                <td>さかがみ</td>
                <td>2019-12-06</td>
                <td>0239-01-01</td>
                <td>2019-12-06</td>
                <td class="ope">
                                        <button class="disabled" disabled onclick="location.href='/task/complete?id=20';">完了</button>
                    <button class="disabled" disabled onclick="location.href='/task/edit?id=20';">更新</button>
                    <button class="disabled" disabled onclick="deleteTask(20, '魏から使者が来るかも？');">削除</button>
                </td>
            </tr>
                                <tr class="expired">
                <td>大化の改新</td>
                <td>がみ</td>
                <td>2019-12-05</td>
                <td>0645-12-05</td>
                <td></td>
                <td class="ope">
                                        <button class="disabled" disabled onclick="location.href='/task/complete?id=5';">完了</button>
                    <button class="disabled" disabled onclick="location.href='/task/edit?id=5';">更新</button>
                    <button class="disabled" disabled onclick="deleteTask(5, '大化の改新');">削除</button>
                </td>
            </tr>
                                <tr class="completed">
                <td>平安京遷都</td>
                <td>さかがみ</td>
                <td>2019-12-06</td>
                <td>0794-12-06</td>
                <td>2019-12-06</td>
                <td class="ope">
                                        <button class="disabled" disabled onclick="location.href='/task/complete?id=19';">完了</button>
                    <button class="disabled" disabled onclick="location.href='/task/edit?id=19';">更新</button>
                    <button class="disabled" disabled onclick="deleteTask(19, '平安京遷都');">削除</button>
                </td>
            </tr>
                                <tr class="expired">
                <td>餃子食べたい</td>
                <td>がみ</td>
                <td>2019-12-05</td>
                <td>2019-12-05</td>
                <td></td>
                <td class="ope">
                                        <button class="disabled" disabled onclick="location.href='/task/complete?id=4';">完了</button>
                    <button class="disabled" disabled onclick="location.href='/task/edit?id=4';">更新</button>
                    <button class="disabled" disabled onclick="deleteTask(4, '餃子食べたい');">削除</button>
                </td>
            </tr>
                                <tr class="expired">
                <td>月曜日のIT基礎ワーク</td>
                <td>さかがみ</td>
                <td>2019-12-06</td>
                <td>2019-12-09</td>
                <td></td>
                <td class="ope">
                                        <button class="disabled" disabled onclick="location.href='/task/complete?id=15';">完了</button>
                    <button class="disabled" disabled onclick="location.href='/task/edit?id=15';">更新</button>
                    <button class="disabled" disabled onclick="deleteTask(15, '月曜日のIT基礎ワーク');">削除</button>
                </td>
            </tr>
                                <tr class="expired">
                <td>さかがみ休み</td>
                <td>さかがみ</td>
                <td>2019-12-06</td>
                <td>2019-12-12</td>
                <td></td>
                <td class="ope">
                                        <button class="disabled" disabled onclick="location.href='/task/complete?id=17';">完了</button>
                    <button class="disabled" disabled onclick="location.href='/task/edit?id=17';">更新</button>
                    <button class="disabled" disabled onclick="deleteTask(17, 'さかがみ休み');">削除</button>
                </td>
            </tr>
                                <tr class="expired">
                <td>叙々苑の焼肉食べたい</td>
                <td>がみ</td>
                <td>2019-12-05</td>
                <td>2019-12-13</td>
                <td></td>
                <td class="ope">
                                        <button class="disabled" disabled onclick="location.href='/task/complete?id=9';">完了</button>
                    <button class="disabled" disabled onclick="location.href='/task/edit?id=9';">更新</button>
                    <button class="disabled" disabled onclick="deleteTask(9, '叙々苑の焼肉食べたい');">削除</button>
                </td>
            </tr>
                                <tr class="expired">
                <td>ビール飲みたい</td>
                <td>がみ</td>
                <td>2019-12-05</td>
                <td>2019-12-20</td>
                <td></td>
                <td class="ope">
                                        <button class="disabled" disabled onclick="location.href='/task/complete?id=3';">完了</button>
                    <button class="disabled" disabled onclick="location.href='/task/edit?id=3';">更新</button>
                    <button class="disabled" disabled onclick="deleteTask(3, 'ビール飲みたい');">削除</button>
                </td>
            </tr>
                                <tr class="expired">
                <td>和歌山ラーメン食べたいです</td>
                <td>さかがみ</td>
                <td>2019-12-06</td>
                <td>2019-12-20</td>
                <td></td>
                <td class="ope">
                                        <button class="disabled" disabled onclick="location.href='/task/complete?id=14';">完了</button>
                    <button class="disabled" disabled onclick="location.href='/task/edit?id=14';">更新</button>
                    <button class="disabled" disabled onclick="deleteTask(14, '和歌山ラーメン食べたいです');">削除</button>
                </td>
            </tr>
                                <tr class="expired">
                <td>レバニラ炒め</td>
                <td>がみ</td>
                <td>2019-12-05</td>
                <td>2019-12-26</td>
                <td></td>
                <td class="ope">
                                        <button class="disabled" disabled onclick="location.href='/task/complete?id=10';">完了</button>
                    <button class="disabled" disabled onclick="location.href='/task/edit?id=10';">更新</button>
                    <button class="disabled" disabled onclick="deleteTask(10, 'レバニラ炒め');">削除</button>
                </td>
            </tr>
            </table>
    <ul class="pagination">
        
                    <li class="disabled"><span>&laquo;</span></li>
        
        
                    
            
            
                                                                        <li class="active"><span>1</span></li>
                                                                                <li><a href="http://192.168.1.50:8081/task?page=2">2</a></li>
                                                        
        
                    <li><a href="http://192.168.1.50:8081/task?page=2" rel="next">&raquo;</a></li>
            </ul>


    </main>

    <footer>
        &copy; 2019 miraino-katachi All Rights Reserved
    </footer>

    <!-- Scripts -->
    <script src="http://192.168.1.50:8081/js/app.js"></script>
<script src="http://192.168.1.50:8081/js/jquery-ui-1.12.1/external/jquery/jquery.js"></script>
<script src="http://192.168.1.50:8081/js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
<script>
$(function() {
    $( "#dialog-confirm"　).hide();
});
function deleteTask(id, task) {
    $( "#task-delete"　).text(task);
    $( "#dialog-confirm" ).dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
            "削除": function() {
                $( this ).dialog( "close" );
                location.href='/task/del?id=' + id;
            },
            "キャンセル": function() {
            $( this ).dialog( "close" );
            }
        }
    });
}
</script>
<div id="dialog-confirm" title="削除"">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
        下記のタスクを削除してもいいですか？<br>
        <p id="task-delete"></p>
    </p>
</div>
</body>
</html>
