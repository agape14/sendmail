# 🚀 Configuración Cron Jobs para Hostinger cPanel

## 📅 Para enviar solo los días 20, 21 y 22 de Septiembre 2025

### **Configuración en cPanel:**

1. **Accede a tu cPanel de Hostinger**
2. **Busca "Cron Jobs"**
3. **Agrega un nuevo Cron Job con esta configuración:**

```bash
# Para envío automático solo en fechas específicas
0 10 20,21,22 09 * /usr/local/bin/php /home/tu-usuario/public_html/sendmail/artisan mype:scheduled-send
```

### **Explicación del Cron:**
- `0 10` = A las 10:00 AM
- `20,21,22` = Solo los días 20, 21 y 22
- `09` = Solo en Septiembre (mes 9)
- `*` = Cualquier año
- `/usr/local/bin/php` = Ruta al PHP en Hostinger
- `/home/tu-usuario/public_html/sendmail/artisan` = Ruta completa a tu proyecto

### **Configuraciones Alternativas:**

#### Opción 1: Un correo por día a las 10 AM
```bash
0 10 20,21,22 09 * /usr/local/bin/php /home/tu-usuario/public_html/sendmail/artisan mype:send-consulta
```

#### Opción 2: Dos correos por día (10 AM y 3 PM)
```bash
0 10,15 20,21,22 09 * /usr/local/bin/php /home/tu-usuario/public_html/sendmail/artisan mype:send-consulta
```

#### Opción 3: Solo el sábado 21 a las 9 AM
```bash
0 9 21 09 6 /usr/local/bin/php /home/tu-usuario/public_html/sendmail/artisan mype:send-consulta
```

### **Pasos en Hostinger cPanel:**

1. **Login a cPanel**
2. **Cron Jobs** → **Add New Cron Job**
3. **Command:** Pegar uno de los comandos de arriba
4. **Cambiar "tu-usuario"** por tu nombre de usuario real
5. **Save**

### **Verificar Rutas:**
- Ruta PHP: `/usr/local/bin/php` (estándar Hostinger)
- Ruta proyecto: `/home/tu-usuario/public_html/sendmail/`
- Si no funciona, probar: `/usr/bin/php`

### **Logs:**
Los logs se guardarán en: `storage/logs/laravel.log`

### **Importante:**
- ✅ Asegúrate que el archivo `.env` esté configurado
- ✅ Permisos correctos en el directorio
- ✅ Credenciales Gmail funcionando
- ✅ Base de datos accesible desde cron
