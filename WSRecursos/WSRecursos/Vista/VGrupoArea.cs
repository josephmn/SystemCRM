using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VGrupoArea : BDconexion
    {
        public List<EGrupoArea> Listar_GrupoArea()
        {
            List<EGrupoArea> lCGrupoArea = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CGrupoArea oVGrupoArea = new CGrupoArea();
                    lCGrupoArea = oVGrupoArea.Listar_GrupoArea(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCGrupoArea);
        }
    }
}