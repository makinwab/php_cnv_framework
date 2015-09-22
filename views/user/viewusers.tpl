<html>
<head>
    <script src="{jquery}" type="text/javascript"></script>
    <script src="{custom}" type="text/javascript"></script>
</head>
<body>
/**
 * Created by JetBrains PhpStorm.
 * User: makinwab
 * Date: 9/4/13
 * Time: 1:00 PM
 * To change this template use File | Settings | File Templates.
 */
 <h1>Users</h1>
{error}

<table border=1>
<tr><th>User id</th><th>Username</th><th>Password</th><th>Status</th><th>Action</th></tr>
{loop}
    <tr>
    <td>{id}</td>
    <td>{username}</td>
    <td>{password}</td>
    <td>{admin}</td>
    <td><a href='{edit}'>Edit</a> <a href='{delete}' class='del'>Delete</a> </td>
    </tr>
{/loop}
</table>

<a href="{back}">Back</a>
<a href="{logout}">Logout</a>
</body>
</html>
