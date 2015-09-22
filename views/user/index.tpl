
/**
 * Created by JetBrains PhpStorm.
 * User: makinwab
 * Date: 9/2/13
 * Time: 3:51 PM
 * To change this template use File | Settings | File Templates.
 */
{try}
{loop}

    <h2> Welcome {user} {username}</h2>

        <h3>Add a user</h3>
        {error}

    <form action="{createuser}" method="post">
        <p>Username: <input type="text" name="uname"></p>
        <p>Password: <input type="password" name="pwd"></p>
        <p>User Type: <select name= "usertype"><option value=1>Admin</option><option value=0>User</option></select></p>
        <p><input type="submit" name="submit"></p>
    </form>

    <a href="{viewusers}">View Users</a>

<a href="{here}">Here</a>
<a href="{paginate}">Pagination</a>
<a href="{logout}">Logout</a>

{/loop}
<p>{foot}</p>
