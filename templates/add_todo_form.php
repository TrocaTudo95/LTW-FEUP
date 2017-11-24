<?php
?>

<div id="add_todo_form">
    <h3>Create ToDo</h3>
    <form>
        <header>
            <input type="text" name="title" required="required" placeholder="Title">
            <input type="text" name="category" required="required" placeholder="Category">
            <input type="color" name="category_color" value="#ff0000">
            <button type="button" id="add_todo_item_button">Add ToDo Item!</button>
        </header>
        <ol id="todo_items">
        </ol>
        <input id="submit_todo_button" type="submit" value="Save List">
    </form>
</div>