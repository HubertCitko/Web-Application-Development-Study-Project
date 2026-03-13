<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

    <xsl:output method="html" doctype-public="-//W3C//DTD HTML 4.01 Transitional//EN" indent="yes"/>

    <xsl:template match="/">
        <html>
            <head>
                <title>Lista filmów</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    table { border-collapse: collapse; width: 100%; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                    img { max-height: 100px; }
                </style>
            </head>
            <body>
                <h1>Lista filmów</h1>
                <xsl:apply-templates select="Filmy"/>
            </body>
        </html>
    </xsl:template>

    <xsl:template match="Filmy">
    <h2>Średnia ocena filmów: 
        <xsl:variable name="średniaOcena" select="sum(Film/Ocena) div count(Film)"/>
        <xsl:value-of select="$średniaOcena"/>
    </h2>
    <xsl:apply-templates select="Film"/>
    </xsl:template>

    <xsl:template match="Film">
        <div>
            <h2><xsl:value-of select="Tytul"/></h2>
            <xsl:apply-templates select="Rezyser"/>
            <p><strong>Rok produkcji:</strong> <xsl:value-of select="RokProdukcji"/></p>
            <p><strong>Gatunek:</strong> <xsl:value-of select="Gatunek"/></p>
            <xsl:apply-templates select="Ocena"/>
            <p><strong>Czas trwania:</strong> <xsl:value-of select="CzasTrwaniaWMinutach"/> minut</p>
            <p><strong>Formaty:</strong> <xsl:value-of select="Formaty"/></p>
            <xsl:apply-templates select="Aktorzy"/>
            <xsl:apply-templates select="StudioProdukcji"/>
        </div>
        <hr/>
    </xsl:template>

    <xsl:template match="Rezyser">
        <p><strong>Reżyser:</strong> 
            <xsl:value-of select="Imie "/><xsl:text> </xsl:text> <xsl:value-of select="Nazwisko"/>
        </p>
        <xsl:apply-templates select="@Narodowosc"/>
        </xsl:template>

        <xsl:template match="Rezyser/@Narodowosc">
        <p><strong>Narodowość reżysera:</strong> <xsl:value-of select="."/></p>
    </xsl:template>

    <xsl:template match="Ocena">
        <xsl:if test=". &gt;= 9">
            <p><strong>Ocena:</strong> <xsl:value-of select="."/> (Top Rated!)</p>
        </xsl:if>
        <xsl:if test=". &lt; 9">
            <p><strong>Ocena:</strong> <xsl:value-of select="."/></p>
        </xsl:if>
    </xsl:template>

    <xsl:template match="Aktorzy">
        <h3>Aktorzy:</h3>
        <xsl:choose>
            <xsl:when test="Aktor">
                <ul>
                    <xsl:apply-templates select="Aktor"/>
                </ul>
            </xsl:when>
            <xsl:otherwise>
                <p>Brak aktorów.</p>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="Aktor">
    <li>
        <xsl:value-of select="DaneAktora/Imie" /><xsl:text> </xsl:text> <xsl:value-of select="DaneAktora/Nazwisko "/>
        (<xsl:value-of select="NazwaRoli"/>)
        <br/>
        <img src="{Zdjecie}" alt="Zdjęcie aktora"/>
        <br/>
        <a href="{Link}" target="_blank">Więcej informacji</a>
    </li>
    </xsl:template>

    <xsl:template match="StudioProdukcji">
    <h3>Studio produkcji:</h3>
    <p>
        <xsl:value-of select="Nazwa"/>,
        <xsl:value-of select="Miasto"/>,
        <xsl:value-of select="Kraj"/>
    </p>
    </xsl:template>

</xsl:stylesheet>