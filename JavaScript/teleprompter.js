document.getElementById('record-button').addEventListener('click', function() {
  document.getElementById('record-modal').classList.add('active');
});
document.getElementById('close-button').addEventListener('click', function() {
  document.getElementById('record-modal').classList.remove('active');
});