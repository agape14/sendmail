# 🚀 Instrucciones para Git Pull en el Servidor

## 📋 **Problema Resuelto**
Ahora cuando hagas `git pull` en el servidor, se crearán automáticamente las carpetas y archivos necesarios.

## 🎯 **Solución Implementada**

### **Archivos Creados:**
1. **`.git/hooks/post-merge`** - Hook que se ejecuta automáticamente después de git pull
2. **`post-git-pull.sh`** - Script manual para ejecutar después de git pull
3. **`INSTRUCCIONES-GIT-PULL.md`** - Este archivo de instrucciones

### **Funcionalidad:**
- ✅ **Crea automáticamente** la carpeta `resources/views/mype/`
- ✅ **Configura permisos** correctos
- ✅ **Limpia cache** automáticamente
- ✅ **Optimiza** la aplicación para producción
- ✅ **Verifica** la estructura de vistas

## 🚀 **Pasos para Desplegar**

### **PASO 1: En tu máquina local**
```bash
# Hacer commit de todos los cambios
git add .
git commit -m "Add: Configuración automática para servidor"
git push origin main
```

### **PASO 2: En el servidor**
```bash
# Conectarse al servidor
ssh u926438338@delacruzdev.tech
cd /home/u926438338/domains/delacruzdev.tech/public_html/sendmail

# Hacer pull (se ejecutará automáticamente la configuración)
git pull origin main

# Si el hook no se ejecutó automáticamente, ejecutar manualmente:
bash post-git-pull.sh
```

### **PASO 3: Verificar**
```bash
# Verificar que la carpeta mype existe
ls -la resources/views/mype/

# Verificar que la vista existe
ls -la resources/views/mype/dashboard-fallback.blade.php

# Probar la URL
curl -I https://sendmail.delacruzdev.tech/
```

## 🎯 **Resultado Esperado**

Después del `git pull`:
- ✅ **Carpeta mype creada** automáticamente
- ✅ **Vista de respaldo disponible** (si se subió)
- ✅ **Cache limpiado** automáticamente
- ✅ **Aplicación optimizada** para producción
- ✅ **https://sendmail.delacruzdev.tech/** - Muestra dashboard

## 🔍 **Verificación**

```bash
# Verificar estructura completa
php artisan mype:verify-views

# Debería mostrar:
# ✓ resources/views/mype/dashboard-fallback.blade.php existe
# ✓ resources/views/emails/mype-consulta.blade.php existe
# ✓ Todas las vistas están presentes
```

## 📁 **Archivos que se Desplegarán**

1. **`.git/hooks/post-merge`** - Hook automático
2. **`post-git-pull.sh`** - Script manual
3. **`resources/views/mype/dashboard-fallback.blade.php`** - Vista de respaldo
4. **`app/Http/Controllers/MyPeController.php`** - Controlador corregido
5. **`app/Console/Commands/VerifyViewsCommand.php`** - Comando de verificación

## 🚨 **Si el Hook No Funciona**

Si el hook automático no se ejecuta, ejecutar manualmente:
```bash
bash post-git-pull.sh
```

## 📞 **Comandos de Diagnóstico**

```bash
# Verificar que el hook existe
ls -la .git/hooks/post-merge

# Verificar permisos del hook
chmod +x .git/hooks/post-merge

# Ejecutar configuración manual
bash post-git-pull.sh
```
