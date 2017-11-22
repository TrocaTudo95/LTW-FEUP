<?php
?>

<div id="add_todo_form">
    <form action="action_add_todo.php" method="post">
        <header>
            <input type="text" name="title" required="required" placeholder="Title">
            <input type="text" name="category" required="required" placeholder="Category">
            <input type="color" name="category_color" value="#ff0000">
        </header>
        <ol>
        <li> <input type="text" name="list_item1" placeholder="Add your item"> </li>
        </ol>
        <input type="submit" value="Save">
    </form>
</div>