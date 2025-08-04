#!/bin/bash

USER="api-lova" # identifiant Alwaysdata
SERVER="ssh-api-lova.alwaysdata.net"
REMOTE_PATH="/home/$USER/api-lova/api-lova.com"

echo "🚀 Push du code vers Alwaysdata..."
git push deploy main

echo "📦 Envoi du fichier .env.prod..."
scp .env.prod $USER@$SERVER:$REMOTE_PATH/.env

echo "⚙ Rafraîchissement de la configuration Laravel..."
ssh $USER@$SERVER << EOF
cd $REMOTE_PATH
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
EOF

echo "✅ Déploiement terminé avec succès !"