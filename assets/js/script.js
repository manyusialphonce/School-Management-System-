// Sidebar toggle
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('collapsed');
}

// Delete confirmation
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault();
        if(confirm('Are you sure you want to delete this record?')){
            window.location.href = this.getAttribute('href');
        }
    });
});