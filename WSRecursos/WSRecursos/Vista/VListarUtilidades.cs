using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarUtilidades : BDconexion
    {
        public List<EListarUtilidades> Listar_ListarUtilidades(Int32 anhio)
        {
            List<EListarUtilidades> lCListarUtilidades = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarUtilidades oVListarUtilidades = new CListarUtilidades();
                    lCListarUtilidades = oVListarUtilidades.Listar_ListarUtilidades(con, anhio);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarUtilidades);
        }
    }
}