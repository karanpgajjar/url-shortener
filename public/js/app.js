$(function () {
    const csrfToken = $("meta[name='csrf-token']").attr("content");

    function handleAjaxForm(formSelector, url) {
        $(formSelector).on("submit", function (e) {
            e.preventDefault();

            const $form = $(this);
            const $button = $form.find("button[type='submit']");
            const $spinner = $button.find("[data-spinner]");

            $form.find(".is-invalid").removeClass("is-invalid");
            $form.find(".invalid-feedback").text("");

            $spinner.removeClass("d-none");
            $button.prop("disabled", true);

            $.ajax({
                url: url,
                method: "POST",
                data: $form.serialize(),
                headers: { "X-CSRF-TOKEN": csrfToken },
            })
                .done(function (response) {
                    showAlert("success", response.message || "Success.");
                    $form.trigger("reset");

                    if (typeof response.reload !== "undefined" && response.reload) {
                        setTimeout(() => window.location.reload(), 800);
                    }
                })
                .fail(function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function (field) {
                            const $input = $form.find(`[name="${field}"], [name="${field.replace(".", "[") + (field.includes(".") ? "]" : "")}"]`);
                            $input.addClass("is-invalid");
                            $form.find(`[data-field="${field}"]`).text(errors[field][0]);
                        });
                    } else if (xhr.status === 403) {
                        showAlert("danger", "You do not have permission to perform this action.");
                    } else {
                        showAlert("danger", "Something went wrong. Please try again.");
                    }
                })
                .always(function () {
                    $spinner.addClass("d-none");
                    $button.prop("disabled", false);
                });
        });
    }

    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`;
        $("#alert-zone").html(alertHtml);
    }

    handleAjaxForm("#short-url-form", "/url-shortener/public/short-urls");
    handleAjaxForm("#invite-company-form", "/url-shortener/public/companies/invite");
    handleAjaxForm("#invite-team-form", "/url-shortener/public/team/invite");
});