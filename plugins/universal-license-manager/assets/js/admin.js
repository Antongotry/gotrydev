/**
 * Universal License Manager Admin JavaScript
 * 
 * @package Universal_License_Manager
 * @author AntonGotry (@notarikon)
 */

jQuery(document).ready(function($) {
    
    // === Modal Functions ===
    function openModal(modalId) {
        $('#' + modalId).fadeIn(300);
        $('body').addClass('modal-open');
    }
    
    function closeModal(modalId) {
        $('#' + modalId).fadeOut(300);
        $('body').removeClass('modal-open');
    }
    
    // Close modal on click outside
    $(document).on('click', '.ulm-modal', function(e) {
        if (e.target === this) {
            closeModal($(this).attr('id'));
        }
    });
    
    // Close modal buttons
    $(document).on('click', '.ulm-modal-close', function() {
        const modal = $(this).closest('.ulm-modal');
        closeModal(modal.attr('id'));
    });
    
    // === Add Product ===
    $('#ulm-add-product-btn').on('click', function() {
        openModal('ulm-add-product-modal');
    });
    
    $('#ulm-add-product-form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            action: 'ulm_create_product',
            nonce: ulm_ajax.nonce,
            name: $('#product_name').val(),
            slug: $('#product_slug').val(),
            version: $('#product_version').val(),
            price: $('#product_price').val(),
            description: $('#product_description').val()
        };
        
        $.post(ulm_ajax.ajax_url, formData, function(response) {
            if (response.success) {
                showNotice('Product created successfully!', 'success');
                closeModal('ulm-add-product-modal');
                location.reload();
            } else {
                showNotice(response.data.message || 'Failed to create product', 'error');
            }
        });
    });
    
    // Auto-generate slug from name
    $('#product_name').on('input', function() {
        const name = $(this).val();
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        $('#product_slug').val(slug);
    });
    
    // === Generate License ===
    $('#ulm-generate-license-btn').on('click', function() {
        openModal('ulm-generate-license-modal');
    });
    
    $('#ulm-generate-license-form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            action: 'ulm_create_license',
            nonce: ulm_ajax.nonce,
            product_id: $('#license_product').val(),
            customer_email: $('#license_email').val(),
            customer_name: $('#license_name').val(),
            activations_limit: $('#license_limit').val(),
            expires_at: $('#license_expires').val(),
            notes: $('#license_notes').val()
        };
        
        $.post(ulm_ajax.ajax_url, formData, function(response) {
            if (response.success) {
                showNotice('License generated successfully! Key: ' + response.data.license_key, 'success');
                closeModal('ulm-generate-license-modal');
                location.reload();
            } else {
                showNotice(response.data.message || 'Failed to generate license', 'error');
            }
        });
    });
    
    // === License Actions ===
    $(document).on('click', '.ulm-copy-license', function() {
        const key = $(this).data('key');
        
        // Copy to clipboard
        navigator.clipboard.writeText(key).then(function() {
            $(this).addClass('copied');
            setTimeout(() => {
                $(this).removeClass('copied');
            }, 2000);
        }.bind(this));
    });
    
    $(document).on('click', '.ulm-toggle-license', function() {
        const id = $(this).data('id');
        const currentStatus = $(this).data('status');
        
        if (!confirm('Are you sure you want to ' + (currentStatus === 'active' ? 'block' : 'activate') + ' this license?')) {
            return;
        }
        
        $.post(ulm_ajax.ajax_url, {
            action: 'ulm_toggle_license_status',
            nonce: ulm_ajax.nonce,
            id: id,
            current_status: currentStatus
        }, function(response) {
            if (response.success) {
                showNotice('License status updated', 'success');
                location.reload();
            } else {
                showNotice(response.data.message || 'Failed to update license', 'error');
            }
        });
    });
    
    $(document).on('click', '.ulm-delete-license', function() {
        const id = $(this).data('id');
        
        if (!confirm('Are you sure you want to delete this license? This action cannot be undone.')) {
            return;
        }
        
        $.post(ulm_ajax.ajax_url, {
            action: 'ulm_delete_license',
            nonce: ulm_ajax.nonce,
            id: id
        }, function(response) {
            if (response.success) {
                showNotice('License deleted successfully', 'success');
                location.reload();
            } else {
                showNotice(response.data.message || 'Failed to delete license', 'error');
            }
        });
    });
    
    $(document).on('click', '.ulm-deactivate-domain', function() {
        const licenseId = $(this).data('license-id');
        const domain = $(this).data('domain');
        
        if (!confirm('Are you sure you want to deactivate this domain?')) {
            return;
        }
        
        // This would need a new AJAX endpoint
        showNotice('Domain deactivation not implemented yet', 'warning');
    });
    
    // === Utility Functions ===
    function showNotice(message, type) {
        const noticeClass = 'ulm-notice-' + type;
        const notice = $('<div class="ulm-notice ' + noticeClass + '">' + message + '</div>');
        
        $('.wrap h1').after(notice);
        
        setTimeout(function() {
            notice.fadeOut(300, function() {
                notice.remove();
            });
        }, 5000);
    }
    
    // === Form Validation ===
    $('.ulm-modal form').on('submit', function(e) {
        const requiredFields = $(this).find('[required]');
        let isValid = true;
        
        requiredFields.each(function() {
            if (!$(this).val().trim()) {
                $(this).css('border-color', '#dc3545');
                isValid = false;
            } else {
                $(this).css('border-color', '#ddd');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            showNotice('Please fill in all required fields', 'error');
        }
    });
    
    // === Loading States ===
    function setLoading(element, loading) {
        if (loading) {
            element.addClass('ulm-loading');
            element.prop('disabled', true);
        } else {
            element.removeClass('ulm-loading');
            element.prop('disabled', false);
        }
    }
    
    // Add loading to form submissions
    $('.ulm-modal form').on('submit', function() {
        setLoading($(this).find('button[type="submit"]'), true);
    });
    
    // === Keyboard Shortcuts ===
    $(document).on('keydown', function(e) {
        // ESC to close modal
        if (e.keyCode === 27) {
            $('.ulm-modal:visible').each(function() {
                closeModal($(this).attr('id'));
            });
        }
    });
    
    // === Auto-refresh for logs ===
    if (window.location.href.indexOf('ulm-logs') !== -1) {
        setInterval(function() {
            // Auto-refresh logs every 30 seconds
            location.reload();
        }, 30000);
    }
    
    // === Tooltips ===
    $('[title]').each(function() {
        $(this).attr('data-tooltip', $(this).attr('title'));
        $(this).removeAttr('title');
    });
    
    // === Responsive Tables ===
    function makeTablesResponsive() {
        $('.wp-list-table').each(function() {
            if ($(this).width() > $(window).width()) {
                $(this).wrap('<div class="table-responsive"></div>');
            }
        });
    }
    
    makeTablesResponsive();
    $(window).on('resize', makeTablesResponsive);
    
    // === Search/Filter ===
    $('.wp-list-table').each(function() {
        const table = $(this);
        const rows = table.find('tbody tr');
        
        // Add search input if not exists
        if (table.find('.search-input').length === 0) {
            const searchInput = $('<input type="text" class="search-input" placeholder="Search..." style="margin-bottom: 10px; padding: 5px 10px; border: 1px solid #ddd; border-radius: 0;">');
            table.before(searchInput);
            
            searchInput.on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                
                rows.each(function() {
                    const rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(searchTerm) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
        }
    });
    
});
