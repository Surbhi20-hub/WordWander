<!-- sidebar.php -->
<div class="sidebar">
    <h2>Admin Panel</h2>
    <nav>
        <a href="admin.php">Dashboard</a>
        <a href="manage_languages.php">Manage Languages</a>
        <a href="user-management.php">User Management</a>
        <a href="/logout.php">LogOut</a>
    </nav>
    <footer>&copy; 2025 Language Learning</footer>
</div>
<style>
    /* Sidebar styles */
.sidebar {
    width: 250px;
    background-color: #2d3e2f;
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 20px;
    height: 100vh; /* Ensure the sidebar takes full height */
    position: fixed;
    top: 0; /* Fix to the top */
    left: 0; /* Ensure it's positioned at the left side */
    box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1);
    overflow-y: auto; /* Make the sidebar scrollable if its content overflows */
}

/* Sidebar headings and links */
.sidebar h2 {
    margin-bottom: 20px;
    font-size: 24px;
    text-align: center;
}

.sidebar nav {
    flex-grow: 1;
}

.sidebar nav a {
    display: block;
    padding: 12px;
    margin: 10px 0;
    color: white;
    text-decoration: none;
    background-color: #3a4e3f;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.sidebar nav a:hover {
    background-color: #2d3e2f;
}

.sidebar footer {
    font-size: 14px;
    text-align: center;
    color: #ddd;
}
</style>
