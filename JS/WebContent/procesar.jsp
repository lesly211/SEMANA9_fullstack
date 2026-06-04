<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Respuesta JSP – Lab09</title>
</head>

<body>
    <div class="card">

        <% if (exito) { %>
            <div class="status-ok">✓</div>
            <h1>¡Procesado por Tomcat!</h1>
            <p class="sub">El Servlet JSP validó y procesó la solicitud correctamente.</p>

            <div class="row"><span class="lbl">Nombre</span> <span class="val"><%= esc.apply(nombre)  %></span></div>
            <div class="row"><span class="lbl">Email</span> <span class="val"><%= esc.apply(email)   %></span></div>
            <div class="row"><span class="lbl">Mensaje</span> <span class="val"><%= esc.apply(mensaje) %></span></div>
            <div class="row"><span class="lbl">Hora</span> <span class="val"><%= new java.text.SimpleDateFormat("HH:mm:ss").format(new java.util.Date()) %></span></div>
            <div class="row"><span class="lbl">IP cliente</span><span class="val"><%= request.getRemoteAddr() %></span></div>

            <div class="session-box">
                <strong>🗂 Sesión activa:</strong> ID = <code><%= session.getId() %></code><br> Atributo guardado: <code>session.setAttribute("mensajeExito", ...)</code>
            </div>

            <% } else { %>
                <div class="status-err">✗</div>
                <h1>Errores de validación</h1>
                <p class="sub">Corrige los errores y vuelve a enviar.</p>

                <div class="errores">
                    <ul>
                        <% for (String e : errores) { %>
                            <li>
                                <%= esc.apply(e) %>
                            </li>
                            <% } %>
                    </ul>
                </div>
                <% } %>

                    <div class="debug">
                        <strong>// DEBUG – JSP/Servlet Info</strong><br> METHOD :
                        <%= esc.apply(request.getMethod()) %><br> SERVER_INFO :
                            <%= esc.apply(application.getServerInfo()) %><br> JAVA_VERSION :
                                <%= System.getProperty("java.version") %><br> CONTEXT_PATH :
                                    <%= esc.apply(request.getContextPath()) %><br> STATUS HTTP :
                                        <%= exito ? "200 OK" : "422 Unprocessable Entity" %>
                    </div>

                    <a class="btn" href="index.jsp">← Volver al formulario</a>
    </div>
</body>

</html>