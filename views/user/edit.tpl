
/**
 * Created by JetBrains PhpStorm.
 * User: makinwab
 * Date: 9/5/13
 * Time: 9:36 AM
 * To change this template use File | Settings | File Templates.
 */

<h2>Edit User</h2>
{loop}
{error}
<form action="{editlink}" method="post">
    <p>Username: <input type="text" name="uname" value="{username}"></p>
    <p>Password: <input type="text" name="pwd"></p>
    <p>User Type:
        <select name= "usertype">
            <option value=1 {aselected} >Admin</option>
            <option value=0 {uselected}>User</option>
        </select>
    </p>
    <p><input type="submit" name="submit" value="Save"></p>
</form>

<a href="{home}">Home</a>
<a href="{users}"> View Users</a>
<a href="{logout}">Logout</a>
{/loop}
