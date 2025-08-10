jQuery(document).ready(function($) {

    function deleteSelectedLeads(data) {
        $.post(ajaxurl, {
            'action': 'delete_leads',
            'data': data,
        })
            .done(function(response) {
                swal({
                    type: 'success',
                    title: 'Deleted',
                    showConfirmButton: false,
                    timer: 1500
                });
                
                setTimeout(() => {
                    window.location.reload()
                }, 1500)
            })
            .fail(function(xhr, status, error) {
                swal({
                    type: 'error',
                    title: 'Error',
                    showConfirmButton: false,
                    timer: 1500
                });
                
                setTimeout(() => {
                    $this.removeAttr('disabled');
                }, 1500)
            });
    }

    
    $('.aios-leads-delete').on('click', function (e) {
        const $this = $(this),
            parents = $this.parents('.wpui-tabs-content'),
            tabsContainer = parents.find('.wpui-tabs-container'),
            data = tabsContainer.find('input.leads:checkbox:checked').map(function () {
                return $(this).val()
            }).get()
        
        if (data.length === 0) {
            swal({
                type: 'error',
                title: 'No lead selected',
                showConfirmButton: false,
                timer: 1500
            });
            
            return false;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to delete the selected leads?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete them!',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    $.post(ajaxurl, {
                        'action': 'delete_leads',
                        'data': data,
                    })
                        .success(function(response) {
                            resolve(response);
                        })
                        .fail(function(xhr, status, error) {
                            reject('Error while deleting leads');
                        });
                })
            },
        }).then((result) => {
            if (result.value) {
                swal({
                    type: 'success',
                    title: 'Deleted',
                    showConfirmButton: false,
                    timer: 1500
                });
                
                setTimeout(() => {
                    window.location.reload()
                }, 1500)
            } 
        }).catch((error) => {
            swal({
                type: 'error',
                title: 'Error',
                showConfirmButton: false,
                timer: 1500
            });
        });
    });


    $('.aios-leads-delete-spams').on('click', function (e) {
        e.preventDefault();

        const $this = $(this),
            title = $this.data('title'),
            category = $this.data('category'),
            count = $this.data('count');

            
        
        if (count === 0) {
            swal({
                type: 'error',
                title: 'There are no spam leads to delete',
                showConfirmButton: false,
                timer: 1500
            });
            
            return false;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: category === "all" ? 'Do you want to delete ' + count + ' spam leads?' : 'Do you want to delete ' + count +  ' spam leads from ' + title + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete them!',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    $.post(ajaxurl, {
                        'action': 'delete_spam_leads',
                        'data': {
                            'category': category,
                        },
                    })
                        .success(function(response) {
                            resolve(response);
                        })
                        .fail(function(xhr, status, error) {
                            reject('Error while deleting leads');
                        });
                })
            },
        }).then((result) => {
            if (result.value) {
                swal({
                    type: 'success',
                    title: 'Deleted',
                    showConfirmButton: false,
                    timer: 1500
                });
                
                setTimeout(() => {
                    window.location.reload()
                }, 1500)
            } 
        }).catch((error) => {
            swal({
                type: 'error',
                title: 'Error',
                showConfirmButton: false,
                timer: 1500
            });
        });
    });
    
});