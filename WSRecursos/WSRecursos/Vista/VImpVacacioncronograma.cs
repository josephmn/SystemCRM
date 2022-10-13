using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VImpVacacioncronograma : BDconexion
    {
        public List<EImpVacacioncronograma> Listar_ImpVacacioncronograma(Int32 id, Int32 anhio)
        {
            List<EImpVacacioncronograma> lCImpVacacioncronograma = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CImpVacacioncronograma oVImpVacacioncronograma = new CImpVacacioncronograma();
                    lCImpVacacioncronograma = oVImpVacacioncronograma.Listar_ImpVacacioncronograma(con, id, anhio);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCImpVacacioncronograma);
        }
    }
}