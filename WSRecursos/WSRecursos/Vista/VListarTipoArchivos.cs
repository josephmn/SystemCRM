using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarTipoArchivos : BDconexion
    {
        public List<EListarTipoArchivos> ListarTipoArchivos(Int32 post, Int32 id, String mime, String type)
        {
            List<EListarTipoArchivos> lCListarTipoArchivos = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarTipoArchivos oVListarTipoArchivos = new CListarTipoArchivos();
                    lCListarTipoArchivos = oVListarTipoArchivos.ListarTipoArchivos(con, post, id, mime, type);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarTipoArchivos);
        }
    }
}