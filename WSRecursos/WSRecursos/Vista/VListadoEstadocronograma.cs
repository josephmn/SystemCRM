using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListadoEstadocronograma : BDconexion
    {
        public List<EListadoEstadocronograma> Listar_ListadoEstadocronograma()
        {
            List<EListadoEstadocronograma> lCListadoEstadocronograma = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListadoEstadocronograma oVListadoEstadocronograma = new CListadoEstadocronograma();
                    lCListadoEstadocronograma = oVListadoEstadocronograma.Listar_ListadoEstadocronograma(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListadoEstadocronograma);
        }
    }
}