const listaActividades = document.getElementById("listaActividades");

async function solicitarApp(metodo,datos) {
    const opciones={
        method: metodo,
        headers: {'Content-Type': 'application/json'},
    }

    if (datos) {
        opciones.body = JSON.stringify(datos);
    }
    
    const respuesta = await fetch ("../Modelo/gestionarActividades.php",opciones);
    const resultado = await respuesta.json();

    if (respuesta.status === 401) {
        window.location.href = "login.html";
    }

    if (!respuesta.ok || !resultado.sucess ) {
        throw new Error(resultado.mensaje || "Error en la solicitud");
    }

    return resultado; 
}