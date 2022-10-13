using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantConveniosTexto : BDconexion
    {
        public List<EMantenimiento> MantConveniosTexto(
            Int32 post,
            Int32 id,
            Int32 iconvenio,
            String texto,
            Int32 tamanio,
            String color,
            Int32 r,
            Int32 g,
            Int32 b,
            Int32 angulo,
            Int32 posicionx,
            Int32 posiciony,
            String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantConveniosTexto oVMantConveniosTexto = new CMantConveniosTexto();
                    lCEMantenimiento = oVMantConveniosTexto.MantConveniosTexto(con, post, id, iconvenio, texto, tamanio, color, r, g, b, angulo, posicionx, posiciony, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}