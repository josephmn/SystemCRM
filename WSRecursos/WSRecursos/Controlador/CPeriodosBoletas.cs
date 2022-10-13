using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CPeriodosBoletas
    {
        public List<EPeriodosBoletas> PeriodosBoletas(SqlConnection con)
        {
            List<EPeriodosBoletas> lEPeriodosBoletas = null;
            SqlCommand cmd = new SqlCommand("ASP_PERIODOS_BOLETAS", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEPeriodosBoletas = new List<EPeriodosBoletas>();

                EPeriodosBoletas obEPeriodosBoletas = null;
                while (drd.Read())
                {
                    obEPeriodosBoletas = new EPeriodosBoletas();
                    obEPeriodosBoletas.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEPeriodosBoletas.v_periodo = drd["v_periodo"].ToString();
                    obEPeriodosBoletas.v_firma = drd["v_firma"].ToString();
                    obEPeriodosBoletas.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obEPeriodosBoletas.v_estado = drd["v_estado"].ToString();
                    obEPeriodosBoletas.v_color_estado = drd["v_color_estado"].ToString();
                    obEPeriodosBoletas.v_lupd_user = drd["v_lupd_user"].ToString();
                    obEPeriodosBoletas.d_lupd_date = drd["d_lupd_date"].ToString();
                    lEPeriodosBoletas.Add(obEPeriodosBoletas);
                }
                drd.Close();
            }

            return (lEPeriodosBoletas);
        }
    }
}