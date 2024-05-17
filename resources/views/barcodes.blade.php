    <!DOCTYPE html>
<html>
<head>
    <title>Barcodes</title>
</head>
<body>

@foreach ($barcodes as $barcode)
    <div class="outer-container">
        <img
            class="barcode-image"
            src="data:image/png;base64, {{ $barcode['image'] }}"
            alt="Barcode"
        />
        <p><strong>Name: </strong>{{$barcode['name']}} </p>
        <p><strong>Company: </strong> {{$barcode['company']}} </p>
    </div>
@endforeach
</body>
</html>

<style>
.outer-container {
    text-align: center;
    margin-bottom: 200px;
}

.barcode-image {
    width: 100%;
}
</style>
