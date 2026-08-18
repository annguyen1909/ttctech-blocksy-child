<?php
/**
 * Create or update the shared Contact Form 7 support form.
 *
 * Usage: wp eval-file wp-content/themes/blocksy-child/bin/seed-contact-form.php
 */

if (!defined('ABSPATH')) {
	exit(1);
}

if (!class_exists('WPCF7_ContactForm')) {
	$message = 'Contact Form 7 must be active.';
	class_exists('WP_CLI') ? WP_CLI::error($message) : print($message . PHP_EOL);
	return;
}

$title = 'TTCTECH – Yêu cầu tư vấn';
$post = get_page_by_path('ttctech-yeu-cau-tu-van', OBJECT, 'wpcf7_contact_form');
$form = $post ? WPCF7_ContactForm::get_instance($post->ID) : WPCF7_ContactForm::get_template([
	'locale' => 'vi',
	'title' => $title,
]);

$mail = $form->prop('mail');
$mail['subject'] = '[_site_title] Yêu cầu tư vấn từ [your-name]';
$mail['sender'] = sprintf('[_site_title] <%s>', WPCF7_ContactFormTemplate::from_email());
$mail['body'] = "Họ và tên: [your-name]\nEmail: [your-email]\nSố điện thoại: [phone]\nCông ty: [company]\nDịch vụ quan tâm: [service]\n\n--\nGửi từ [_site_title] ([_site_url])";
$mail['additional_headers'] = 'Reply-To: [your-email]';

$messages = $form->prop('messages');
$messages = array_merge($messages, [
	'mail_sent_ok' => 'Cảm ơn bạn. Yêu cầu đã được gửi thành công, TTCTECH sẽ liên hệ trong giờ làm việc.',
	'mail_sent_ng' => 'Chưa thể gửi yêu cầu. Vui lòng thử lại hoặc liên hệ trực tiếp qua hotline.',
	'validation_error' => 'Vui lòng kiểm tra lại các trường được đánh dấu bên dưới.',
	'spam' => 'Yêu cầu chưa được gửi. Vui lòng thử lại sau.',
	'invalid_required' => 'Vui lòng điền thông tin này.',
	'invalid_too_long' => 'Nội dung vượt quá độ dài cho phép.',
	'invalid_too_short' => 'Nội dung chưa đủ độ dài yêu cầu.',
	'invalid_email' => 'Vui lòng nhập đúng địa chỉ email.',
	'invalid_tel' => 'Vui lòng nhập đúng số điện thoại.',
]);

$form->set_title($title);
$form->set_properties([
	'form' => <<<'FORM'
<div class="ttc-support__form-head">
<p class="ttc-support__note">Vui lòng điền đầy đủ thông tin để nhận được sự hỗ trợ nhanh nhất từ đội ngũ của chúng tôi.</p>
</div>
<div class="ttc-support__fields">
<label class="ttc-support__field"><span class="screen-reader-text">Họ và tên</span>[text* your-name autocomplete:name placeholder "Họ và tên *"]</label>
<label class="ttc-support__field"><span class="screen-reader-text">Email</span>[email* your-email autocomplete:email placeholder "Email *"]</label>
<label class="ttc-support__field"><span class="screen-reader-text">Số điện thoại</span>[tel* phone autocomplete:tel placeholder "Số điện thoại *"]</label>
<label class="ttc-support__field"><span class="screen-reader-text">Tên công ty</span>[text company autocomplete:organization placeholder "Tên công ty"]</label>
<label class="ttc-support__field ttc-support__field--wide"><span class="screen-reader-text">Dịch vụ bạn quan tâm</span>[select* service first_as_label "Dịch vụ bạn quan tâm *" "Tư vấn dụng cụ" "Hỗ trợ kỹ thuật" "Yêu cầu báo giá"]</label>
</div>
<div class="ttc-support__actions">
[submit class:ttc-support__submit "Submit"]
</div>
FORM,
	'mail' => $mail,
	'messages' => $messages,
]);

$id = $form->save();
$message = $id ? "Contact Form 7 form #{$id} is ready." : 'Could not save the Contact Form 7 form.';

if (class_exists('WP_CLI')) {
	$id ? WP_CLI::success($message) : WP_CLI::error($message);
} else {
	echo $message . PHP_EOL;
}
