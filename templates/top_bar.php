<section id="top_bar" class="topBar">
    <span id="new_project" class="topBar"onClick="new_project_click()">New Project</span>
    <form id="search_form" class="topBar">
      <input type="search" id="searchfield" placeholder="Search" oninput="updateProjects()">
    </form>
    <select id="filter" class="topBar">
      <option value="name">Name</option>
      <option value="category">Category</option>
      <option value="task">Task</option>
    </select>
</section>
