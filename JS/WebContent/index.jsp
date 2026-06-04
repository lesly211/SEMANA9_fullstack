<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lab09 JSP – Formulario</title>
</head>

<body>
    <div class="card">
        <span class="badge">JSP — Semana 09</span>
        <h1>Formulario JSP</h1>
        <p class="sub">Datos enviados a <code>procesar.jsp</code> vía HTTP POST.</p>

        <%-- Mensaje de sesión previa --%>
            <%
      String sesionMsg = (String) session.getAttribute("mensajeExito");
      if (sesionMsg != null) {
          session.removeAttribute("mensajeExito");
    %>
                <div>
                    ✓
                    <%= sesionMsg %>
                </div>
                <% } %>

                    <form action="procesar.jsp" method="post">
                        <label>Nombre completo</label>
                        <input type="text" name="nombre" placeholder="Ej: María García" required />

                        <label>Correo electrónico</label>
                        <input type="email" name="email" placeholder="correo@ejemplo.com" required />

                        <label>Mensaje</label>
                        <textarea name="mensaje" placeholder="Escribe aquí..." required></textarea>

                        <button type="submit">Enviar →</button>
                    </form>

                    <p class="info">
                        Servidor: <code>localhost:8080/lab09/</code> | Java <code><%= System.getProperty("java.version") %></code> | IS093A UNCP
                    </p>
    </div>
</body>

</html>