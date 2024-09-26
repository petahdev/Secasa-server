// Function to toggle sidebar
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
    
    // Add event listener to the document when sidebar is active
    if (sidebar.classList.contains('active')) {
        document.addEventListener('click', closeSidebarOnOutsideClick);
    } else {
        document.removeEventListener('click', closeSidebarOnOutsideClick);
    }
}

// Function to close sidebar when clicking outside of it
function closeSidebarOnOutsideClick(event) {
    const sidebar = document.getElementById('sidebar');
    const toggleButton = document.querySelector('.toggle-button');
    
    // Check if click happened outside the sidebar and the toggle button
    if (!sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
        sidebar.classList.remove('active');
        document.removeEventListener('click', closeSidebarOnOutsideClick); // Remove listener after closing
    }
}
