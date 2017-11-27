<div id="add_todo_form">
    <h3>Create ToDo</h3>
    <form method="get" action="action_save_list.php">
        <header>
            <input type="text" id="todo_title" required="required" placeholder="Title">
            <input type="text" id="todo_category" required="required" placeholder="Category">
            <input type="color" id="todo_color" value="#ff0000">
            <button type="button" id="add_todo_item_button">Add ToDo Item!</button>
        </header>
        <ol id="todo_items">
        </ol>
        <input id="submit_todo_button" type="submit" value="Save List" disabled="disabled">
    </form>
</div>