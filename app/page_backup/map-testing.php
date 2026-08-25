<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        async function puchifa() {
            try {
                const response = await axios.get('https://script.google.com/macros/s/AKfycbx5wV4eIIuql0u__3vgzMb-b6uFHxvjeOQYj6YJ36vnAkbDXZxM2S8vLDbTxtbcvdEq9g/exec');
                dt = response.data[0];
                //console.log(`column1 ${parseFloat(dt.column3)+parseFloat(dt.column4)+parseFloat(dt.column5)+parseFloat(dt.column6)+parseFloat(dt.column7)+parseFloat(dt.column8)+parseFloat(dt.column9)+parseFloat(dt.column10)+parseFloat(dt.column11)}`);
                console.log(`${dt.column1}`);
            } catch (error) {
                console.error(error);
            }
        }
        puchifa();
        /* 

        "column1": "08/11/2024", Date
        "column2": "1:11:13", Time
        "column3": "0.016639", Lux
        "column4": "17.03071", mag/arcsec²
        "column5": "0", PM2.5
        "column6": "0", PM10.0
        "column7": "0", Temperature
        "column8": "24", Humity
        "column9": "70.82", Pressure
        "column10": "975", Altitude
        "column11": "321", Weather
        "column12": "Clear"
        */
    </script>
</body>

</html>