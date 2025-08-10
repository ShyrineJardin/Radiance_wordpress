document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.dashboard-view-full-logs').forEach((element) => {
    element.addEventListener('click', (event) => {
      event.preventDefault(); // Prevent default link behavior

      // Find the next <tr> with the class 'dashboard-full-logs' and toggle its visibility
      const nextRow = element.closest('tr').nextElementSibling;
      if (nextRow && nextRow.classList.contains('dashboard-full-logs')) {
        nextRow.style.display = nextRow.style.display === 'none' || !nextRow.style.display ? 'table-row' : 'none';
      }
    });
  });
});