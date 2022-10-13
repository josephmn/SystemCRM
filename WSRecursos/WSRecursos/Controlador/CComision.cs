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
    public class CComision
    {
        public List<EComision> Listar_Comision(SqlConnection con, Int32 post, String dni)
        {
            List<EComision> lEComision = null;
            SqlCommand cmd = new SqlCommand("ASP_COMISION", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlParameter par1 = cmd.Parameters.Add("@post", SqlDbType.Int);
            par1.Direction = ParameterDirection.Input;
            par1.Value = post;

            SqlParameter par2 = cmd.Parameters.Add("@dni", SqlDbType.Int);
            par2.Direction = ParameterDirection.Input;
            par2.Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEComision = new List<EComision>();

                EComision obEComision = null;
                while (drd.Read())
                {
                    obEComision = new EComision();
                    obEComision.i_id = drd["i_id"].ToString();
                    obEComision.d_fecha = drd["d_fecha"].ToString();
                    obEComision.v_mes = drd["v_mes"].ToString();
                    obEComision.i_tipo_comision = drd["i_tipo_comision"].ToString();
                    obEComision.v_tipo_comision = drd["v_tipo_comision"].ToString();
                    obEComision.i_estado = drd["i_estado"].ToString();
                    obEComision.v_estado = drd["v_estado"].ToString();
                    obEComision.v_color = drd["v_color"].ToString();
                    obEComision.d_aprobacion_jefe = drd["d_aprobacion_jefe"].ToString();
                    obEComision.v_aprobar_jefe = drd["v_aprobar_jefe"].ToString();
                    obEComision.d_aprobacion_rrhh = drd["d_aprobacion_rrhh"].ToString();
                    obEComision.v_aprobar_rrhh = drd["v_aprobar_rrhh"].ToString();
                    lEComision.Add(obEComision);
                }
                drd.Close();
            }

            return (lEComision);
        }
    }
}