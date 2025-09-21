# 🚀 Configuración Cron Job para Producción - Hostinger

## 📅 ENVÍO ESPECÍFICO: 20, 21, 22 Septiembre 2025

### **Para cPanel de Hostinger:**

#### **Opción 1: Un correo por día a las 10:00 AM**
```bash
0 10 20,21,22 09 * /usr/local/bin/php /home/tu-usuario/public_html/sendmail/artisan mype:send-consulta --force
```

#### **Opción 2: Dos correos por día (10 AM y 4 PM)**
```bash
0 10,16 20,21,22 09 * /usr/local/bin/php /home/tu-usuario/public_html/sendmail/artisan mype:send-consulta --force
```

#### **Opción 3: Solo sábado y domingo (más natural)**
```bash
0 10 21,22 09 6,0 /usr/local/bin/php /home/tu-usuario/public_html/sendmail/artisan mype:send-consulta --force
```

## 📋 PASOS EN HOSTINGER cPANEL

### 1. **Acceder a cPanel**
- Login en tu cuenta Hostinger
- Ir a cPanel

### 2. **Configurar Cron Job**
- Buscar **"Cron Jobs"** en cPanel
- Hacer clic en **"Cron Jobs"**

### 3. **Agregar Nuevo Cron Job**
- **Comando:** Copiar uno de los comandos de arriba
- **Cambiar "tu-usuario"** por tu nombre de usuario real
- **Guardar**

### 4. **Verificar Rutas**
Si no funciona, probar estas variantes de PHP:
```bash
# Opción 1
/usr/local/bin/php /home/tu-usuario/public_html/sendmail/artisan mype:send-consulta --force

# Opción 2  
/usr/bin/php /home/tu-usuario/public_html/sendmail/artisan mype:send-consulta --force

# Opción 3
php /home/tu-usuario/public_html/sendmail/artisan mype:send-consulta --force
```

## ⏰ EXPLICACIÓN DEL CRON

### Formato: `minuto hora día mes día-semana comando`

**Ejemplo:** `0 10 20,21,22 09 *`
- `0` = Minuto 0 (en punto)
- `10` = Hora 10 (10:00 AM)
- `20,21,22` = Días 20, 21 y 22
- `09` = Septiembre (mes 9)
- `*` = Cualquier día de la semana

## 🎯 RECOMENDACIÓN

**Para tu caso específico:**
```bash
0 10 20,21,22 09 * /usr/local/bin/php /home/tu-usuario/public_html/sendmail/artisan mype:send-consulta --force
```

**Esto enviará:**
- **Viernes 20 Sept** a las 10:00 AM
- **Sábado 21 Sept** a las 10:00 AM  
- **Domingo 22 Sept** a las 10:00 AM

## 📊 MONITOREO

**Logs se guardan en:**
- `storage/logs/laravel.log`

**Ver estadísticas:**
```bash
php artisan mype:stats
```
