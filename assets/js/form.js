$(document).ready(function(){
    const $checkboxes = $('input[name="country[]"]');
    const $selectAll = $('#select-all');
  
    $selectAll.on('click', () => {
      $checkboxes.prop('checked', $selectAll.prop('checked'));
    });
  
    $('form').on('submit', event => {
      if (!$checkboxes.is(':checked')) {
        event.preventDefault();
        alert('Please select at least one country.');
      }
    });
  
  });