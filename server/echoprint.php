<?php
require_once 'connection.php';

if(isset($_FILES['file']) && !$_FILES['file']['error']
    && isset($_POST['filename'])
    && isset($_POST['key'])){

    //TODO: check if key already exists in database
    //echo json_encode(array('error' => 'Key already exists'));
    //exit;

    //save recorded wav file
    $filename = $_POST['filename'];
    $key =  $_POST['key'];

    $wav_file_url = "recordings/" . $filename;

    move_uploaded_file($_FILES['file']['tmp_name'], $wav_file_url);

    //TODO: generate code string with echoprint from wav file
    //code below is fake for testing
    $code = '{"metadata":{"artist":"", "release":"", "title":"", "genre":"", "bitrate":256,"sample_rate":44100, "duration":19, "filename":"test.mp3", "samples_decoded":220592, "given_duration":20, "start_offset":0, "version":4.12, "codegen_time":0.058830, "decode_time":0.155138}, "code_count":666, "code":"eJzVl11yJisORLcESPwtB5DY_xLmgGP6u-EY44eO-zDt6HS4KISQUilVCCFYeEDSF0h_QSkvqPMFPb1g-gt8PiDG-gKVF_DGA1Z_wc4PSOfSP8JvcdYXvCM5-gt2eUAsTziO_whJ9wtOOH-GVl-w9gN-Y7u8QNYLSn7BL1loD_iNsfqCPF9QxwN-y9GLsek4_jOYPuCvcvRLFuQFc7_gF1VpL3jnqMYXrPGCXR-Q6nqB5Qdwrxf8UinjBX-To2el_JbB9YDfMphf8M5g9wekE7Cf4UTkZ_glv-UBv-T3rzrO_2GVPXMUb7v7CVIYL3jm6F-ssiPSP8M7g-_Z7K-qrLzglwyGFzx1MoX4gvf09Vc5mi94K-EvWXjNwPFQ72f4q0qxF_xSKf0FbyX8i2lEOOAnSNmaUeWGpMZhu2qg_bXZm9u2YGNb3DuvtWU3bdZXHLFLM6mhtV7z3VbCinP3uUYstbbp0ZKm2eLde1_pMnO8r9xVb01a9lj2tbfSmr2k7Htp2unLlz8vlx5jxrTkOjzv_7W6a-8-t3f5Oo2Afq0Ksis6TUKxHutdnbXK7GksvasiWSZFNNvddu3FHjWWxQp-2tIWdLahg_er1oibO0VbOVlYJdhusUWpNfY9Uo2LYBQazfJVba6V-3WtVq-6aNV9Jtf1gd115W_PPmCtWmqeUypzDl82SnHCNvvQYuQlzmDNl5AEbykLHpVltAw8SFzPtcyqe6bNtWdJfXvpBLNndwy0aSlN8R7XNiU1uW-boyhh8VSlzCyj6VRvIW-vdbvwOaHbjfNtWPVBnEkvNYIbe8U4axs54_Xu5M0TkRycuuMcW8KyPfifTKCExqlVyDssmgRCQtsjxFTcxGerOmJM4nm1NGcQD7kvq1vDudqKJGZ-gExr-PbsA0RphG2baxObyr8ylZhUiN-DNo21p8Z7U0ebyyRPKUXVR1xUi2taiy8WSwMKwQ5Koqqbty24OK22PSNRqms2c-W25IZkaBm4VkeNatnDzl65pUzC1VtRhxwcyNVwowySZVRnilV6FGtjZU0YSeM8EtiUhwtFODLlStows-c-BxJorhAasd7Um7dFKrXHXsizaePEsQpaJWVI4dzDq1qKdPIUcMP31mGh15rVZ54wbobSNrGxXXQl7TtPynbtabgmeVMsMevojZPVQtbijTKgKKI0CN8zL-LeHyhcf3579gEBNXp0HUvaGWvlBGa23Mro5MJyHnnpdO4-Qi6w2qpl5WTLiRyH5N4g6d5JbBIpT3dvFEjnx29olEm8svrH8mf17v1a7TXpP1aX1HFXc1kdYqq00LKFu4oS1fxl76yumJPLINfX6LWH0M3Y22xSqNPUZGf9snfS5tpHdFG4fqgIk9h0tnHhWFuPm_BSe9N509bmbC59BkP3I692t4WNCNVZKXokzq4blmqnqFrZH7gx-PbsA1lyo-IUGRhEJCE6jkxRFKUhBzmNM8-cbMTMoatBnd4LumotoqQlbymUUaixNeUkT92gDiGCrNtnWpkT6HzQBHqq1vtKXLZaN5z1Uai-NgiiF97V0GED0ts6ia6ZEO-Kpp9xXlezHb52_HkZ5UKpYzCnllO9q_cK79Xrhsyda6AhEQSU7K52pZpoei3c1dhWTXSJ8WWqE7fKUFvjXR20GL-r1zzCvFBrug8KoH0y_MaIfKRr-ePL3etDe78GrkP33Gvgrl6HrmWdeHMduueOtUL6wL3lt2cf0HgEriErsAxansaJxC643PlTEKiI-MqIIdopA8gXRRMbadR6mgP6GQ3RN0NE12AO2TXb1l7Qg4lj56dcy4wC5DGfjtxX3WWWXO5qL8j_Xb2WP6tbYDKaK4VvG2iUc7bPaqb4nIgjkhv_lwuW1hxy7V1PMZBQddIERSiz46e4LQoY2ZuKLA5PdrozQwX9_IwqMaPHiAkVW0LlgkRC0g5oEkdX_Bx7N-GamDF6DV2fSHJsQM5jO8XaaJEfuEa_PfsA21PiF42NTCPDC5MUz-liDqVPCHbaX6s-jWmk4RFTSkXbo4a7l9ZaVSnEVBtTTmFwSddyRzlq0Yqe5NyhV15508Oo2s6dmWsSNJlGWEbUWcqJMK1VjAn8iD7TDaGViFGM4I5mzww6WfqEKTBb5jrD1BKqirGE_NMcpdKqEvGS2Bl9kKNFe5BZYILJQCc8EcfhmGMWyvQSpgHvVvLQiPzT6ND3ORKRWL2frsnEZyeUVK6NlSpln0YWfnkfM6jn3nNLNA1G_NEZQgaEGRn6wmJhOq9Oq0hMFhOrp63_F7Au9u3ZBzatm_kciYiMJovuKpU-cMLbuBQazTTLzRmkUUQK1c5QMEbg9uE0fqc9D24ZyGkloTmgG40GoGZI2VX-AnclryJQD6KXkTZp4wL9SHSiuJTpsQSo2JiQEjfDhQIFaekRpc3LoQAUCYSEecuHOwJzerDWFpmZLcXDFKSNPjZEIStKHCXy7cnQl_kAGKd06BqhlkhNrVYhZmaGZVJjBCmjRVPmOPpR5-NvMPQwBm-4SEsfNPs5qXcNsqyrpOk7MAE3Bm4-q91xgVKDZHpm9o7sbFovg-OKbTCMoHZbGupU6kBgGEOZuQQ_Tj87bpzWghZRAodmEIMJCIaS3QQHymqrOLLRmJDSP2ATa_n27AP_Ab6sdGs=", "tag":0}';

    //delete wav file
    unlink($wav_file_url);

    //echonest api call
    $url = "http://developer.echonest.com/api/v4/song/identify";
    $api_key = 'YZ5AQSBJDZXKCJ8A8';

    $data = array(
        'api_key'=>$api_key,
        'query'=>$code
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $result = curl_exec($ch);

    //TODO: save result with key in database

    //echo success message
    echo json_encode(array('success' => 'Found a result! Successfully stored in the database with key: ' . $key));
    exit;

} else {

    //echo error message
    echo json_encode(array('error' => 'Missing or invalid post parameters'));
    exit;
}