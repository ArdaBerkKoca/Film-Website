<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-panel">
        <h1>Dizi Ekle Panel</h1>
        <form action="/submit-form" method="POST">
            <label for="DiziAdi">Dizi Adı</label>
            <input type="text" id="DiziAdi" name="DiziAdi">
            
            <label for="DiziAciklamasi">Dizi Açıklaması</label>
            <input type="text" id="DiziAciklamasi" name="DiziAciklamasi">
            
            <label for="kategori">Kategori</label>
            <input type="text" id="kategori" name="kategori">
            
            <label for="yonetmen">Yönetmen</label>
            <input type="text" id="yonetmen" name="yonetmen">
            
            <label for="soundtrack">Soundtrack</label>
            <input type="text" id="soundtrack" name="soundtrack">
            
            <label for="youtubeLink">YouTube Link</label>
            <input type="text" id="youtubeLink" name="youtubeLink">
            
            <button type="submit">Dizi Ekle</button>
        </form>
    </div>
</body>
</html>
