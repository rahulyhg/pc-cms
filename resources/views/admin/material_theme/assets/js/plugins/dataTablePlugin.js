/* Data table plugins */

/* Selectbox plugin */
(function($) {

    const $checkbox = $('.pc-selectable-input');
    const $checkboxLength = $checkbox.length;
    const $selectableRow = $('.pc-selectable-row');
    const $checkboxSelectAll = $('.pc-selectable-input-all');
    const $selectedCounter = $('.pc-selectable-counter');
    const $massActions = $('.pc-cms-mass-actions');
    const $selectedValuesInput = $('.pc-cms-selected-values-input');

    $selectedCounter.hide();
    $massActions.hide();
    $selectedValuesInput.val('');

    $checkbox.on('change', onCheckboxChangeHandler)
    $checkboxSelectAll.on('change', onCheckboxSelectAllChangeHandler);

    function onCheckboxChangeHandler(e) {
        const $target = $(e.target);
        if ($target[0].checked) {
            $target.closest('tr.pc-selectable-row').addClass('highlight');
            if (getLengthSelectedCheckboxes() === $checkboxLength) {
                $checkboxSelectAll[0].checked = true;
            }
            setCounter();
        } else {
            $target.closest('tr.pc-selectable-row').removeClass('highlight');
            if (getLengthSelectedCheckboxes() !== $checkboxLength) {
                $checkboxSelectAll[0].checked = false;
            }
            setCounter();
        }
        addValueToSelectedValuesInput();
    }

    function onCheckboxSelectAllChangeHandler(e){
        const $target = $(e.target);
        if ($target[0].checked) {
            $selectableRow.addClass('highlight');
            selectAllCheckboxes();
            setCounter();
        } else {
            $selectableRow.removeClass('highlight');
            selectAllCheckboxes(false);
            setCounter();
        }
        addValueToSelectedValuesInput();
    }

    function selectAllCheckboxes(select = true){
        $checkbox.each(function(index, checkbox){
            checkbox.checked = select;
        });
    }

    function getLengthSelectedCheckboxes(){
        const $selectedCheckboxes = $checkbox.filter(':checked');
        return $selectedCheckboxes.length;
    }

    function setCounter(){
        const length = getLengthSelectedCheckboxes();
        if (length === 0) {
            $selectedCounter.hide();
            $massActions.hide();
        } else {
            if (length === 1) {
                $selectedCounter.text('1 item selected');
            } else {
                $selectedCounter.text(length + ' items selected');
            }
            $selectedCounter.show();
            $massActions.show();
        }
    }

    function addValueToSelectedValuesInput() {
        $selectedValuesInput.val('');
        const $selectedCheckbox = $('.pc-selectable-input').filter(':checked');
        const selected_values = [];
        $selectedCheckbox.each(function(index, checkbox){
            const itemId = parseInt(checkbox.dataset.itemId);
            selected_values.push(itemId);
        });
        $selectedValuesInput.val(selected_values.toString());
    }

})(jQuery);