# Overlay LESS non-intrusif — Aligné sur votre thème
Ce dossier **n'altère aucun fichier** de votre thème. Il ajoute un skin activable depuis le layout.

## Activer dans votre layout (ex: `layouts/default.htm`)
```twig
<link rel="stylesheet" href="{{ 'assets/less/_overlay_modern/theme.less'|theme }}">
{% styles %}
```

## Personnaliser
Modifiez `variables.less` (couleurs, radius, container, etc.).

## Désactiver
Retirez simplement la ligne d'inclusion ci-dessus.
