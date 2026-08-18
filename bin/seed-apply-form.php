<?php
/**
 * Create or update the Contact Form 7 recruitment (application) form.
 * Mirrors bin/seed-contact-form.php but for job applications.
 *
 * Usage: wp eval-file wp-content/themes/blocksy-child/bin/seed-apply-form.php
 */

if (!defined('ABSPATH')) {
	exit(1);
}

if (!class_exists('WPCF7_ContactForm')) {
	$message = 'Contact Form 7 must be active.';
	class_exists('WP_CLI') ? WP_CLI::error($message) : print($message . PHP_EOL);
	return;
}

$title = 'TTCTECH – Ứng tuyển';
$post = get_page_by_path('ttctech-ung-tuyen', OBJECT, 'wpcf7_contact_form');
$form = $post ? WPCF7_ContactForm::get_instance($post->ID) : WPCF7_ContactForm::get_template([
	'locale' => 'vi',
	'title' => $title,
]);

$mail = $form->prop('mail');
$mail['subject'] = '[_site_title] Hồ sơ ứng tuyển: [position] – [your-name]';
$mail['sender'] = sprintf('[_site_title] <%s>', WPCF7_ContactFormTemplate::from_email());
$mail['recipient'] = 'info@ttctech.vn';
$mail['body'] = "Họ và tên: [your-name]\nEmail: [your-email]\nSố điện thoại: [phone]\nVị trí ứng tuyển: [position]\nLink hồ sơ/CV: [cv-link]\n\nGiới thiệu bản thân:\n[your-message]\n\n--\nGửi từ [_site_title] ([_site_url])";
$mail['additional_headers'] = 'Reply-To: [your-email]';

$messages = $form->prop('messages');
$messages = array_merge($messages, [
	'mail_sent_ok' => 'Cảm ơn bạn đã ứng tuyển. Hồ sơ đã được gửi, TTCTECH sẽ liên hệ khi phù hợp.',
	'mail_sent_ng' => 'Chưa thể gửi hồ sơ. Vui lòng thử lại hoặc gửi trực tiếp qua email tuyển dụng.',
	'validation_error' => 'Vui lòng kiểm tra lại các trường được đánh dấu bên dưới.',
	'spam' => 'Hồ sơ chưa được gửi. Vui lòng thử lại sau.',
	'invalid_required' => 'Vui lòng điền thông tin này.',
	'invalid_too_long' => 'Nội dung vượt quá độ dài cho phép.',
	'invalid_email' => 'Vui lòng nhập đúng địa chỉ email.',
	'invalid_tel' => 'Vui lòng nhập đúng số điện thoại.',
]);

$form->set_title($title);
$form->set_properties([
	'form' => <<<'FORM'
<div class="ttc-support__form-head">
<p class="ttc-support__note">Điền thông tin để ứng tuyển — đội ngũ TTCTECH sẽ liên hệ lại với bạn.</p>
<p class="ttc-support__required"><span aria-hidden="true">*</span> Thông tin bắt buộc</p>
</div>
<div class="ttc-support__fields">
<label class="ttc-support__field"><span class="screen-reader-text">Họ và tên</span>[text* your-name autocomplete:name placeholder "Họ và tên *"]</label>
<label class="ttc-support__field"><span class="screen-reader-text">Email</span>[email* your-email autocomplete:email placeholder "Email *"]</label>
<label class="ttc-support__field"><span class="screen-reader-text">Số điện thoại</span>[tel* phone autocomplete:tel placeholder "Số điện thoại *"]</label>
<label class="ttc-support__field"><span class="screen-reader-text">Vị trí ứng tuyển</span>[select* position first_as_label "Vị trí ứng tuyển *" "Kỹ sư ứng dụng dụng cụ cắt" "Nhân viên kinh doanh kỹ thuật" "Ứng tuyển chủ động (vị trí khác)"]</label>
<label class="ttc-support__field ttc-support__field--wide"><span class="screen-reader-text">Link hồ sơ / CV</span>[text cv-link placeholder "Link hồ sơ / CV"]</label>
<label class="ttc-support__field ttc-support__field--wide"><span class="screen-reader-text">Giới thiệu bản thân</span>[textarea your-message maxlength:1000 x4 placeholder "Giới thiệu bản thân"]</label>
</div>
<div class="ttc-support__actions">
[submit class:ttc-support__submit "Gửi hồ sơ ứng tuyển"]
<span class="ttc-support__privacy">Hồ sơ chỉ được dùng cho mục đích tuyển dụng của TTCTECH.</span>
</div>
FORM,
	'mail' => $mail,
	'messages' => $messages,
]);

$id = $form->save();
$message = $id ? "Apply form #{$id} is ready." : 'Could not save the apply form.';

if (class_exists('WP_CLI')) {
	$id ? WP_CLI::success($message) : WP_CLI::error($message);
} else {
	echo $message . PHP_EOL;
}
